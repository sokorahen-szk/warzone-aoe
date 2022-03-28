<?php declare(strict_types=1);

namespace Package\Usecase\Game\GameRecord\GetList;

use Package\Usecase\Game\GameRecord\GetList\GameRecordListByDateRangeData;
use Package\Usecase\Game\GameRecord\GetList\GameRecordListByDateRangeCommand;

interface GameRecordListByDateRangeServiceInterface
{
    public function handle(GameRecordListByDateRangeCommand $command): ?GameRecordListByDateRangeData;
}
