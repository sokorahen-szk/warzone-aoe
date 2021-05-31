<?php declare(strict_types=1);

namespace Package\Usecase\Game\GameRecord\GetList;

use Package\Usecase\Data;

class GameRecordListByDateRangeData extends Data
{
    public $gameRecords;

    public function __construct(array $sources)
    {
        $response = [];

        foreach ($sources as $source) {
            $response[] = [
                'gameRecordId'          => $source->getGameRecordId()->getValue(),
                'gamePackageId'         => $source->getGamePackageId()->getValue(),
                'playerMemoryId'        => $source->getPlayerMemory()->getPlayerMemoryId()->getValue(),
                'team'                  => $source->getPlayerMemory()->getTeam()->getValue(),
                'rank'                  => $source->getPlayerMemory()->getMu()->getRank(),
                'rate'                  => $source->getPlayerMemory()->getRate()->getValue(),
                'winningTeam'           => $source->getWinningTeam()->getValue(),
                'status'                => $source->getStatus()->getValue(),
                'startedAt'             => $source->getStartedAt()->getDatetime(),
                'finishedAt'            => $source->getFinishedAt()->getDatetime(),
            ];
        }

        $this->gameRecords = $response;
    }
}
