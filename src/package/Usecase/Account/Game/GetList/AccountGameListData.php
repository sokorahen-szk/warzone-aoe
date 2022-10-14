<?php declare(strict_types=1);

namespace Package\Usecase\Account\Game\GetList;

use Package\Domain\Game\ValueObject\GameRecord\GameTeam;
use Package\Usecase\Data;

/**
 * Data Transfer Object
 */

class AccountGameListData extends Data {
    public $gameRecords;

    public function __construct(array $sources)
    {
        $response = [];
        foreach ($sources as $source) {
            $response[] = [
                'gameRecordId' => $source->getGameRecordId()->getValue(),
                'gamePackage' => [
                    'id' => $source->getGamePackage()->getGamePackageId()->getValue(),
                    'name' => $source->getGamePackage()->getName()->getValue(),
                ],
                'gameMap' => [
                    'id' => $source->getGameMap()->getGameMapId()->getValue(),
                    'name' => $source->getGameMap()->getName()->getValue(),
                    'imagePath' => $source->getGameMap()->getImage()->getValue(),
                ],
                'gameRule' => [
                    'id' => $source->getGameRule()->getGameRuleId()->getValue(),
                    'name' => $source->getGameRule()->getName()->getValue(),
                ],
                'playerCount' => count($source->getPlayerMemories()),
                'team1RateSum' => $source->getRateSum(new GameTeam(1)),
                'team2RateSum' => $source->getRateSum(new GameTeam(2)),
                'status' => $source->getGameStatus()->getValue(),
                'startedAt' => $source->getStartedAt()->getDatetime(),
            ];
        }
        $this->gameRecords = $response;
    }
}