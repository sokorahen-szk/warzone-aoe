<?php declare(strict_types=1);

namespace Package\Usecase\Game\GameRecord\GetList;

class GameRecordListByDateRangeCommand
{
    public $userId;
    public $muEnabled;
    public $beginDate;
    public $endDate;

    public function __construct(
        int $userId,
        bool $muEnabled,
        string $beginDate,
        ?string $endDate
    ) {
        $this->userId = $userId;
        $this->muEnabled = $muEnabled;
        $this->beginDate = $beginDate;
        $this->endDate = $endDate;
    }
}
