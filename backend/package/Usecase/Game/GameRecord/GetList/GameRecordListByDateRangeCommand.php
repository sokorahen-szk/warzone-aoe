<?php declare(strict_types=1);

namespace Package\Usecase\Game\GameRecord\GetList;

class GameRecordListByDateRangeCommand
{
    public $userId;
    public $muEnabled;
    public $gamePackageId;
    public $beginDate;
    public $endDate;

    public function __construct(
        int $userId,
        bool $muEnabled,
        int $gamePackageId,
        string $beginDate,
        ?string $endDate
    ) {
        $this->userId = $userId;
        $this->muEnabled = $muEnabled;
        $this->gamePackageId = $gamePackageId;
        $this->beginDate = $beginDate;
        $this->endDate = $endDate;
    }
}
