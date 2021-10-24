<?php declare(strict_types=1);

namespace Package\Infrastructure\Eloquent\Game;

use Package\Domain\Game\Repository\GameMapRepositoryInterface;
use App\Models\MapModel as EloquentGameMap;
use Package\Domain\Game\ValueObject\GamePackage\GamePackageId;
use Package\Domain\Game\ValueObject\GameMap\GameMapId;
use Package\Domain\System\ValueObject\Name;
use Package\Domain\Game\ValueObject\GameMap\Image;
use Package\Domain\System\ValueObject\Description;
use Package\Domain\Game\Entity\GameMap;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Log;

use Package\Infrastructure\Eloquent\Converter;

class GameMapRepository implements GameMapRepositoryInterface {
  /**
   * @return array|null
   */
  public function list(): ?array
  {
    $gameMaps = EloquentGameMap::get();

    if (!$gameMaps) {
      return null;
    }

    $results = [];

    foreach ($gameMaps as $gameMap) {
      $results[] = new GameMap([
        'gameMapId'        => new GameMapId($gameMap->id),
        'gamePackageId'    => new GamePackageId($gameMap->game_package_id),
        'name'             => new Name($gameMap->name),
        'image'            => new Image($gameMap->image),
        'description'      => new Description($gameMap->description),
      ]);
    }

    return $results;
  }

  /**
   * ゲームマップを取得する
   *
   * @param GameMapId $gameMapId
   * @return GameMap
   */
  public function get(GameMapId $gameMapId): GameMap
  {
    try {
      $gameMap = EloquentGameMap::findOrFail($gameMapId->getValue());
      $resource = Converter::gameMap($gameMap);
    } catch (ModelNotFoundException $e) {
      Log::Info($e->getMessage());
      throw new ModelNotFoundException(sprintf("ゲームマップID %d の情報が存在しません。", $gameMapId->getValue()));
    }

    return $resource;
  }
}