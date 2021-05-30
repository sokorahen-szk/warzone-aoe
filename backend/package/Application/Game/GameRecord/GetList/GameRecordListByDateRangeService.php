<?php declare(strict_types=1);

namespace Package\Application\Game\GameRecord\GetList;

use Package\Usecase\Game\GameRecord\GetList\GameRecordListByDateRangeServiceInterface;
use Package\Usecase\Game\GameRecord\GetList\GameRecordListByDateRangeCommand;
use Package\Usecase\Game\GameRecord\GetList\GameRecordListByDateRangeData;
use Package\Domain\Game\Repository\GameRecordRepositoryInterface;
use Package\Domain\User\Repository\UserRepositoryInterface;

use Package\Domain\User\ValueObject\UserId;
use Package\Domain\System\ValueObject\Date;

class GameRecordListByDateRangeService implements GameRecordListByDateRangeServiceInterface
{
    private $gameRecordRepository;
    private $userRepository;

    public function __construct(
        GameRecordRepositoryInterface $gameRecordRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->gameRecordRepository = $gameRecordRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(GameRecordListByDateRangeCommand $command): ?GameRecordListByDateRangeData
    {
        $user = $this->userRepository->findUserById(new UserId($command->userId));

        $gameRecords = $this->gameRecordRepository->listByDateRange($user, new Date($command->beginDate), new Date($command->endDate));
        return new GameRecordListByDateRangeData($gameRecords);
    }
}
