<?php declare(strict_types=1);

namespace Package\Usecase\Game\TeamDivision;

use Package\Usecase\Data;

class GameTeamDivisionData extends Data
{
    public $division;
    public $gamePackageId;
    public $ruleId;
    public $mapId;

    public function __construct($sources, $gamePackage, $gameRule, $gameMap)
    {
        $this->division = $sources;
        $this->gamePackageId = $gamePackage->getGamePackageId()->getValue();
        $this->ruleId = $gameRule->getGameRuleId()->getValue();
        $this->mapId = $gameMap->getGameMapId()->getValue();
    }
}
