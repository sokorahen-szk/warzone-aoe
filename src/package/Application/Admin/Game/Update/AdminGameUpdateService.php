<?php declare(strict_types=1);

namespace Package\Application\Admin\Game\Update;

use Package\Usecase\Admin\Game\Update\AdminGameUpdateServiceInterface;
use Package\Usecase\Admin\Game\Update\AdminGameUpdateCommand;

use Package\Domain\Game\Repository\GameRecordRepositoryInterface;
use Package\Domain\Game\ValueObject\GameRecord\GameRecordId;
use Package\Domain\Game\ValueObject\GameRecord\GameStatus;
use Package\Domain\Game\ValueObject\GameRecord\GameTeam;
use Package\Domain\User\Repository\UserRepositoryInterface;
use Exception;
use Package\Domain\System\ValueObject\Datetime;
use Package\Usecase\System\UpdateGameSystemServiceInterface;

class AdminGameUpdateService implements AdminGameUpdateServiceInterface {
    private $gameRecordRepository;
    private $updateGameSystemService;

    private $sendPushNotification = true;

    public function __construct(
        GameRecordRepositoryInterface $gameRecordRepository,
        UpdateGameSystemServiceInterface $updateGameSystemService
    )
    {
        $this->gameRecordRepository = $gameRecordRepository;
        $this->updateGameSystemService = $updateGameSystemService;
    }

    public function handle(AdminGameUpdateCommand $command)
    {
		$currentDatetime = new Datetime(now());
        $gameRecordId = new GameRecordId($command->gameRecordId);
        $gameStatus = new GameStatus($command->status);

        $winningTeam = null;
        if ($command->winningTeam) {
            $winningTeam = new GameTeam($command->winningTeam);
        }

        $gameRecord = $this->gameRecordRepository->getById($gameRecordId);

        if (!$gameRecord->getGameStatusIsMatching()) {
            throw new Exception('マッチング中以外はステータスの変更はできません。');
        }

        $this->updateGameSystemService->handle(
            $gameRecord,
            $winningTeam,
            $gameStatus,
            $currentDatetime,
            $this->sendPushNotification
        );
    }
}