<?php declare(strict_types=1);

namespace Package\Application\Game\Finished;

use Package\Domain\Game\Repository\GameRecordRepositoryInterface;
use Package\Domain\Game\Repository\GameRecordTokenRepositoryInterface;
use Package\Domain\Game\ValueObject\GameRecordToken\GameToken;
use Package\Domain\Game\ValueObject\GameRecord\GameStatus;
use Package\Domain\Game\ValueObject\GameRecord\GameTeam;
use Package\Usecase\Game\Finished\GameFinishedServiceInterface;
use Package\Usecase\Game\Finished\GameFinishedCommand;
use Package\Domain\System\ValueObject\Datetime;
use Exception;
use Package\Usecase\System\UpdateGameSystemServiceInterface;

class GameFinishedService implements GameFinishedServiceInterface
{
    private $gameRecordTokenRepository;
    private $gameRecordRepository;
    private $updateGameSystemService;

    public function __construct(
        GameRecordTokenRepositoryInterface $gameRecordTokenRepository,
        GameRecordRepositoryInterface $GameRecordRepository,
        UpdateGameSystemServiceInterface $updateGameSystemService
    )
    {
        $this->gameRecordTokenRepository = $gameRecordTokenRepository;
        $this->gameRecordRepository = $GameRecordRepository;
        $this->updateGameSystemService = $updateGameSystemService;
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

        $this->updateGameSystemService->handle(
            $gameRecord,
            $winningTeam,
            $gameStatus,
            $currentDatetime
        );
    }
}