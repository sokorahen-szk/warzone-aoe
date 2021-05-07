<?php declare(strict_types=1);

namespace Package\Usecase\Game\GameMap\GetList;

use Package\Usecase\Game\GameMap\GetList\GameMapData;
use Package\Usecase\Game\GameMap\GetList\GameMapListCommand;

interface GameMapListServiceInterface {
  public function handle(GameMapListCommand $command): ?GameMapData;
}