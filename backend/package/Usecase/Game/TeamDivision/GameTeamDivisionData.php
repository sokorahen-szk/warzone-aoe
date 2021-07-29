<?php declare(strict_types=1);

namespace Package\Usecase\Game\TeamDivision;

use Package\Usecase\Data;

class GameTeamDivisionData extends Data
{
    public $teamDivision;

    public function __construct(array $sources)
    {
        $response = [];

        $this->teamDivision = $response;
    }
}
