<?php declare(strict_types=1);

namespace Package\Usecase\Game\GameMap\GetList;

use Package\Usecase\Game\GameMap\GetList\GameMapData;

interface GameMapListServiceInterface {
  public function handle(): ?GameMapData;
}