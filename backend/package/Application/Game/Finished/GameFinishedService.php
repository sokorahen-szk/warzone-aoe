<?php declare(strict_types=1);

namespace Package\Application\Game\Finished;

use Package\Domain\Game\Repository\GameRecordRepositoryInterface;
use Package\Domain\Game\Repository\GameRecordTokenRepositoryInterface;
use Package\Domain\Game\ValueObject\GameRecordToken\GameToken;
use Package\Domain\Game\ValueObject\GameRecord\GameStatus;
use Package\Domain\Game\ValueObject\GameRecord\GameTeam;
use Package\Usecase\Game\Finished\GameFinishedServiceInterface;
use Package\Usecase\Game\Finished\GameFinishedCommand;
use DB;
use Exception;
use Package\Infrastructure\TrueSkill\TrueSkillClient;
use Package\Domain\User\Entity\PlayerMemory;
use Package\Domain\User\Entity\Player;
use Package\Domain\User\Repository\PlayerMemoryRepositoryInterface;
use Package\Domain\Game\ValueObject\GameRecord\GameRecordId;
use Package\Domain\User\Repository\PlayerRepositoryInterface;
use Package\Domain\System\ValueObject\Datetime;
use Package\Domain\User\Service\PlayerServiceInterface;

class GameFinishedService implements GameFinishedServiceInterface
{
    private $gameRecordTokenRepository;
    private $gameRecordRepository;
    private $playerMemoryRepository;
    private $playerRepository;
    private $playerService;

    private $trueSkillClient;

    public function __construct(
        GameRecordTokenRepositoryInterface $gameRecordTokenRepository,
        GameRecordRepositoryInterface $GameRecordRepository,
        PlayerMemoryRepositoryInterface $playerMemoryRepository,
        PlayerRepositoryInterface $playerRepository,
        PlayerServiceInterface $playerService
    )
    {
        $this->gameRecordTokenRepository = $gameRecordTokenRepository;
        $this->gameRecordRepository = $GameRecordRepository;
        $this->playerMemoryRepository = $playerMemoryRepository;
        $this->playerRepository = $playerRepository;
        $this->playerService = $playerService;

		// TODO: 今後RepositoryからTrueSkillのデータ取り出すように包括するかもしれない
		$this->trueSkillClient = new TrueSkillClient();
    }

    public function handle(GameFinishedCommand $command): void
    {
		$currentDatetime = new Datetime(now());
        $gameToken = new GameToken($command->token);
        $gameRecordToken = $this->gameRecordTokenRepository->getByGameToken($gameToken);

        $gameStatus = new GameStatus($command->status);

        $winningTeam = null;
        if ($command->winningTeam) {
            $winningTeam = new GameTeam($command->winningTeam);
        }

        $gameRecord = $this->gameRecordRepository->getById($gameRecordToken->getGameRecordId());

        if (!$gameRecord->getGameStatusIsMatching()) {
            throw new Exception('マッチング中以外はステータスの変更はできません。');
        }

        if (!$gameRecordToken->isValidExpires($currentDatetime)) {
            throw new Exception('ゲームトークンの有効期限が切れています。');
        }

		try {
			DB::beginTransaction();

            $players = $this->pluckPlayer($gameRecord->getPlayerMemories(), $winningTeam, $gameStatus);

            if ($gameStatus->isFinished()) {
                // TrueSkill問合せ

                // GameRecordからplayer情報取得して、mu, sigma, rate書き換え

                $gameRecord->changeWinningTeam($winningTeam);
            }

            $gameRecord->changeGameStatus($gameStatus);

            // ゲームレコード更新
            $this->gameRecordRepository->update($gameRecord);

            // プレイヤー記録更新
            $this->updatePlayerMemories($gameRecord->getGameRecordId(), $players);

            // プレイヤー更新
            $this->updatePlayer($players, $currentDatetime);

			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			throw $e;
		}

        // https://github.com/sokorahen-szk/warzone-aoe/issues/85
        // TODO: ここにゲーム終了の通知をDiscordに送る処理
    }

    /**
     * @param PlayerMemory[] $playerMemories
     * @param GameTeam|null $winningTeam
     * @return Player[]
     */
    private function pluckPlayer(array $playerMemories, ?GameTeam $winningTeam, GameStatus $gameStatus): array
    {
        $players = [];
        foreach ($playerMemories as $playerMemory) {
            $player = $playerMemory->getPlayer();

            if ($gameStatus->isFinished()) {
                if ($winningTeam->getValue() === $playerMemory->getTeam()->getValue()) {
                    $player = $this->playerService->changeWinnerPlayer($player);
                } else {
                    $player = $this->playerService->changeDefeatPlayer($player);
                }
            } else if ($gameStatus->isDraw()) {
                $player = $this->playerService->changeDrawPlayer($player);
            }

            $players[] = $player;
        }

        return $players;
    }

    /**
     * @param GameRecordId $gameRecordId
     * @param Player[] $players
     * @return void
     */
    private function updatePlayerMemories(GameRecordId $gameRecordId, array $players): void
    {
        foreach($players as $player) {
            $this->playerMemoryRepository->update($gameRecordId, $player);
        }
    }

    /**
     * @param Player[] $players
     * @return void
     */
    private function updatePlayer(array $players, Datetime $currentDatetime): void
    {
        foreach($players as $player) {
            $player->changeLastGameAt($currentDatetime);
            $this->playerRepository->update($player);
        }
    }
}