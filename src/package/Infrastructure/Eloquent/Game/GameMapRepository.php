<?php declare(strict_types=1);

namespace Package\Infrastructure\Eloquent\Game;

use Package\Domain\Game\Repository\GameMapRepositoryInterface;
use App\Models\MapModel as EloquentGameMap;
use Package\Domain\Game\ValueObject\GameMap\GameMapId;
use Package\Domain\Game\Entity\GameMap;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Log;

use Package\Infrastructure\Eloquent\Converter;

class GameMapRepository implements GameMapRepositoryInterface
{
  /**
   * ゲームマップ一覧を取得する
   * @return GameMap[]
   */
  public function list(): array
  {
    $gameMaps = EloquentGameMap::get();

    return Converter::gameMaps($gameMaps);
  }

  /**
   * 特定のゲームマップを取得する
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