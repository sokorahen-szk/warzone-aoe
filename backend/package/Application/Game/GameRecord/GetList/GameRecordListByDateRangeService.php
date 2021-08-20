<?php declare(strict_types=1);

namespace Package\Application\Game\GameRecord\GetList;

use Package\Usecase\Game\GameRecord\GetList\GameRecordListByDateRangeServiceInterface;
use Package\Usecase\Game\GameRecord\GetList\GameRecordListByDateRangeCommand;
use Package\Usecase\Game\GameRecord\GetList\GameRecordListByDateRangeData;
use Package\Domain\Game\Repository\GameRecordRepositoryInterface;
use Package\Domain\User\Repository\UserRepositoryInterface;
use Package\Domain\Game\ValueObject\GameRecord\GameRecordMuEnabled;
use  Package\Domain\Game\ValueObject\GamePackage\GamePackageId;

use Package\Domain\User\ValueObject\UserId;
use Package\Domain\System\ValueObject\Date;
use Carbon\Carbon;

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
        $endDate = $command->endDate ? new Date($command->endDate) : new Date(Carbon::parse($command->beginDate)->endOfMonth());

        $gameRecordMuEnabled = new GameRecordMuEnabled($command->muEnabled);

        $gameRecords = $this->gameRecordRepository->listRaitingByUserWithDateRange(
            $user,
            new GamePackageId($command->gamePackageId),
            new Date($command->beginDate),
            $endDate
        );
        return new GameRecordListByDateRangeData($gameRecords, $gameRecordMuEnabled);
    }
}
