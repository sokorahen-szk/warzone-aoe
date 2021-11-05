<?php declare(strict_types=1);

namespace Package\Application\Account\Game\GetList;

use Package\Domain\Game\Repository\GameRecordRepositoryInterface;
use Package\Domain\Game\ValueObject\GameRecord\GameStatus;
use Package\Domain\User\Repository\UserRepositoryInterface;
use Package\Domain\User\ValueObject\UserId;
use Package\Usecase\Account\Game\GetList\AccountGameListServiceInterface;
use Package\Usecase\Account\Game\GetList\AccountGameListData;
use Package\Usecase\Account\Game\GetList\AccountGameListCommand;

class AccountGameListService implements AccountGameListServiceInterface {
    private $gameRecordRepository;
    private $userRepository;

    public function __construct(
        GameRecordRepositoryInterface $gameRecordRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->gameRecordRepository = $gameRecordRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(AccountGameListCommand $command): AccountGameListData
    {
        $user = $this->userRepository->findUserById(new UserId($command->userId));

        $gameMatchingStatus = new GameStatus(GameStatus::GAME_STATUS_MATCHING);

        $gameRecords = $this->gameRecordRepository->listHistoryByUsserWithStatus($user, $gameMatchingStatus);
        return new AccountGameListData($gameRecords);
    }
}