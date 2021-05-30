<?php declare(strict_types=1);

namespace Package\Usecase\Game\GameRecord\GetList;

use Package\Usecase\Data;

class GameRecordListByDateRangeData extends Data
{
    public $gameRecords;

    public function __construct(array $sources)
    {
        $response = [];

        $this->gameRecords = $sources;
    }
}
