<?php declare(strict_types=1);

namespace Package\Usecase\Game\TeamDivision;

use Package\Usecase\Data;

class GameTeamDivisionData extends Data
{
    public $divisions;

    public function __construct($sources)
    {
        $this->divisions = $sources;
    }
}
