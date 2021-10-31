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
use Package\Domain\System\ValueObject\Datetime;
use Package\Infrastructure\TrueSkill\TrueSkillClient;
use Package\Domain\User\Entity\PlayerMemory;
use Package\Domain\User\Entity\Player;

class GameFinishedService implements GameFinishedServiceInterface
{
    private $gameRecordTokenRepository;
    private $gameRecordRepository;
    private $trueSkillClient;

    public function __construct(
        GameRecordTokenRepositoryInterface $gameRecordTokenRepository,
        GameRecordRepositoryInterface $GameRecordRepository
        )
    {
        $this->gameRecordTokenRepository = $gameRecordTokenRepository;
        $this->gameRecordRepository = $GameRecordRepository;

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

        $players = $this->pluckPlayer($gameRecord->getPlayerMemories());

		try {
			DB::beginTransaction();

            if ($gameStatus->isFinished()) {
                // TrueSkill問合せ

                // GameRecordからplayer情報取得して、mu, sigma, rate書き換え
            } else {
                //
            }

            if ($winningTeam) {
                $gameRecord->changeWinningTeam($winningTeam);
            }

            $gameRecord->changeGameStatus($gameStatus);

            // ゲームレコード更新
            // $this->gameRecordRepository->update($gameRecord);

            // game_record.idに紐づく、player_memoriesのデータを更新する。

            // 各プレイヤーのplayers情報を更新する。rate, mu, sigma, 勝ち負け数、ゲーム数、連勝、連敗など。

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
     * @return Player[]
     */
    private function pluckPlayer(array $playerMemories): array
    {
        $players = [];
        foreach ($playerMemories as $playerMemory) {
            $players[] = $playerMemory->getPlayer();
        }

        return $players;
    }

}