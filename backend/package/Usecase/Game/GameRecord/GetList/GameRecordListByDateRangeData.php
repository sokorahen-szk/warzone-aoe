<?php declare(strict_types=1);

namespace Package\Usecase\Game\GameRecord\GetList;

use Package\Usecase\Data;
use Package\Domain\Game\ValueObject\GameRecord\GameRecordMuEnabled;

class GameRecordListByDateRangeData extends Data
{
    public $gameRecords;

    public function __construct(array $sources, GameRecordMuEnabled $gameRecordMuEnabled)
    {
        $response = [];

        foreach ($sources as $key => $source) {
            $response[$key] = [
                'gameRecordId'          => $source->getGameRecordId()->getValue(),
                'gamePackageId'         => $source->getGamePackageId()->getValue(),
                'playerMemoryId'        => $source->getPlayerMemory()->getPlayerMemoryId()->getValue(),
                'team'                  => $source->getPlayerMemory()->getTeam()->getValue(),
                'rank'                  => $source->getPlayerMemory()->getMu()->getRank(),
                'rate'                  => $source->getPlayerMemory()->getRate()->getValue(),
                'winningTeam'           => $source->getWinningTeam()->getValue(),
                'status'                => $source->getStatus()->getValue(),
                'startedAt'             => $source->getStartedAt()->getDate(),
                'finishedAt'            => $source->getFinishedAt()->getDate(),
            ];

            if ($gameRecordMuEnabled->getValue()) {
                $response[$key]['mu'] = $source->getPlayerMemory()->getMu()->getValue();
            }
        }

        $this->gameRecords = $response;
    }
}
