<?php declare(strict_types=1);

namespace Package\Application\Account\Game\StatusUpdate;

use Package\Domain\Game\Repository\GameRecordRepositoryInterface;
use Package\Domain\Game\ValueObject\GameRecord\GameRecordId;
use Package\Domain\Game\ValueObject\GameRecord\GameStatus;
use Package\Domain\Game\ValueObject\GameRecord\GameTeam;
use Package\Domain\User\Repository\UserRepositoryInterface;
use Package\Domain\User\ValueObject\UserId;
use Package\Usecase\Account\Game\StatusUpdate\AccountGameStatusUpdateCommand;
use Package\Usecase\Account\Game\StatusUpdate\AccountGameStatusUpdateServiceInterface;
use Exception;
use Package\Domain\System\ValueObject\Datetime;
use Package\Usecase\System\UpdateGameSystemServiceInterface;

class AccountGameStatusUpdateService implements AccountGameStatusUpdateServiceInterface {
    private $userRepository;
    private $gameRecordRepository;
    private $updateGameSystemService;

    public function __construct(
        UserRepositoryInterface $userRepository,
        GameRecordRepositoryInterface $gameRecordRepository,
        UpdateGameSystemServiceInterface $updateGameSystemService
    )
    {
        $this->userRepository = $userRepository;
        $this->gameRecordRepository = $gameRecordRepository;
        $this->updateGameSystemService = $updateGameSystemService;
    }

    public function handle(AccountGameStatusUpdateCommand $command): void
    {
		$currentDatetime = new Datetime(now());

        $user = $this->userRepository->findUserById(new UserId($command->userId));
        $gameRecordId = new GameRecordId($command->gameRecordId);

        $gameStatus = new GameStatus($command->status);

        $winningTeam = null;
        if ($command->winningTeam) {
            $winningTeam = new GameTeam($command->winningTeam);
        }

        $gameRecord = $this->gameRecordRepository->getById($gameRecordId);

        if ($user->getId()->getValue() !== $gameRecord->getUserId()->getValue()) {
            throw new Exception('試合作成ユーザのみ、ゲーム記録を付ける事が可能です。');
        }

        if (!$gameRecord->getGameStatusIsMatching()) {
            throw new Exception('マッチング中以外はステータスの変更はできません。');
        }

        $this->updateGameSystemService->handle(
            $gameRecord,
            $winningTeam,
            $gameStatus,
            $currentDatetime
        );
    }
}