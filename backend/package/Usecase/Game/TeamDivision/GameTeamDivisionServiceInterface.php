<?php declare(strict_types=1);

namespace Package\Usecase\Game\TeamDivision;

interface GameTeamDivisionServiceInterface
{
    public function handle(GameTeamDivisionCommand $command): GameTeamDivisionData;
}
