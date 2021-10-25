<?php declare(strict_types=1);

namespace Package\Usecase\Game\GameMap\GetList;

class GameMapListCommand {
  public $gamePackageId;

  public function __construct(
    int $gamePackageId
  )
  {
    $this->gamePackageId = $gamePackageId;
  }
}