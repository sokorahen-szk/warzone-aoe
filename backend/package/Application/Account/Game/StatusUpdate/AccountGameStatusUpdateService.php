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

class AccountGameStatusUpdateService implements AccountGameStatusUpdateServiceInterface {
    private $userRepository;
    private $gameRecordRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        GameRecordRepositoryInterface $gameRecordRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->gameRecordRepository = $gameRecordRepository;
    }

    public function handle(AccountGameStatusUpdateCommand $command): void
    {
        $user = $this->userRepository->findUserById(new UserId($command->userId));
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

        // TODO:
    }
}