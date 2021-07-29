<?php declare(strict_types=1);

namespace Package\Usecase\Game\TeamDivision;

class GameTeamDivisionCommand {
  public $playerIds;
  public $gamePackageId;
  public $ruleId;
  public $mapId;

  public function __construct(
    array $playerIds,
	  int $gamePackageId,
    int $ruleId,
    int $mapId
  )
  {
    $this->playerIds = $playerIds;
    $this->gamePackageId = $gamePackageId;
    $this->ruleId = $ruleId;
    $this->mapId = $mapId;
  }
}