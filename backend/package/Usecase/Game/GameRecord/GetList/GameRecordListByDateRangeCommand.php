<?php declare(strict_types=1);

namespace Package\Usecase\Game\GameRecord\GetList;

class GameRecordListByDateRangeCommand
{
    public $userId;
    public $beginDate;
    public $endDate;

    public function __construct(
        int $userId,
        string $beginDate,
        ?string $endDate
    ) {
        $this->userId = $userId;
        $this->beginDate = $beginDate;
        $this->endDate = $endDate;
    }
}
