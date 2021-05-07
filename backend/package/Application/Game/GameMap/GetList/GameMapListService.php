<?php declare(strict_types=1);

namespace Package\Application\Game\GameMap\GetList;

use Package\Usecase\Game\GameMap\GetList\GameMapListServiceInterface;
use Package\Usecase\Game\GameMap\GetList\GameMapData;
use Package\Domain\Game\Repository\GameMapRepositoryInterface;
use Package\Usecase\Game\GameMap\GetList\GameMapListCommand;
use Package\Domain\Game\ValueObject\Id as GamePackageId;

class GameMapListService implements GameMapListServiceInterface {
  private $gameMapRepository;

  public function __construct(
    GameMapRepositoryInterface $gameMapRepository
  )
  {
    $this->gameMapRepository = $gameMapRepository;
  }

  public function handle(GameMapListCommand $command): ?GameMapData
  {
    $gamePackageId = new GamePackageId($command->gamePackageId);
    $gameMaps = $this->gameMapRepository->list($gamePackageId);

    if (is_null($gameMaps)) {
      return null;
    }

    return new GameMapData($gameMaps);
  }
}