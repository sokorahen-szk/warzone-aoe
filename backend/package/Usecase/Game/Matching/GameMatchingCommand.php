<?php declare(strict_types=1);

namespace Package\Usecase\Game\Matching;

class GameMatchingCommand {
  public $userId;
  public $playerIds;
  public $gamePackageId;
  public $ruleId;
  public $mapId;

  public function __construct(
    ?int $userId,
    array $playerIds,
	  int $gamePackageId,
    int $ruleId,
    int $mapId
  )
  {
    $this->userId = $userId;
    $this->playerIds = $playerIds;
    $this->gamePackageId = $gamePackageId;
    $this->ruleId = $ruleId;
    $this->mapId = $mapId;
  }
}