<?php declare(strict_types=1);

namespace Package\Infrastructure\Eloquent\Game;

use Package\Domain\Game\Repository\GameMapRepositoryInterface;
use App\Models\MapModel as EloquentGameMap;
use Package\Domain\Game\ValueObject\Id as GamePackageId;
use Package\Domain\Game\ValueObject\Id as GameMapId;
use Package\Domain\Game\ValueObject\Name as GameMapName;
use Package\Domain\Game\ValueObject\GameMap\Image;
use Package\Domain\Game\ValueObject\Description as GamePackageDescription;
use Package\Domain\Game\Entity\GameMap;

class GameMapRepository implements GameMapRepositoryInterface {
  /**
   * @return array|null
   */
  public function list(GamePackageId $gamePackageId): ?array
  {
    $gameMaps = EloquentGameMap::where('game_package_id', $gamePackageId->getValue())->get();

    if (!$gameMaps) {
      return null;
    }

    $results = [];

    foreach ($gameMaps as $gameMap) {
      $results[] = new GameMap([
        'gameMapId'               => new GameMapId($gameMap->id),
        'gamePackageId'           => new GamePackageId($gameMap->game_package_id),
        'gameMapName'             => new GameMapName($gameMap->name),
        'image'                   => new Image($gameMap->image),
        'gameMapDescription'      => new GamePackageDescription($gameMap->description),
      ]);
    }

    return $results;
  }
}