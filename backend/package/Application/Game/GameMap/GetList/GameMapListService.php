<?php declare(strict_types=1);

namespace Package\Application\Game\GameMap\GetList;

use Package\Usecase\Game\GameMap\GetList\GameMapListServiceInterface;
use Package\Usecase\Game\GameMap\GetList\GameMapData;
use Package\Domain\Game\Repository\GameMapRepositoryInterface;

class GameMapListService implements GameMapListServiceInterface {
  private $gameMapRepository;

  public function __construct(
    GameMapRepositoryInterface $gameMapRepository
  )
  {
    $this->gameMapRepository = $gameMapRepository;
  }

  public function handle(): ?GameMapData
  {
    $gameMaps = $this->gameMapRepository->list();

    if (is_null($gameMaps)) {
      return null;
    }

    return new GameMapData($gameMaps);
  }
}