<?php declare(strict_types=1);

namespace Package\Usecase\Player\PlayerList;

class PlayerListCommand
{
  public $gamePackageId;

  public function __construct(
    int $gamePackageId
  )
  {
    $this->gamePackageId = $gamePackageId;
  }
}
