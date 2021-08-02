<?php declare(strict_types=1);

namespace Package\Infrastructure\Eloquent\Game;

use Package\Domain\Game\Repository\GamePackageRepositoryInterface;
use Package\Domain\Game\Entity\GamePackage;
use Package\Domain\Game\ValueObject\GamePackage\GamePackageId;
use Package\Domain\System\ValueObject\Description;
use Package\Domain\System\ValueObject\Name;
use App\Models\GamePackageModel as EloquentGamePackage;
use Exception;
use Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GamePackageRepository implements GamePackageRepositoryInterface {
  /**
   * @return array|null
   */
  public function list(): ?array
  {
    $gamePackages = EloquentGamePackage::get();

    if (!$gamePackages) {
      return null;
    }

    $results = [];

    foreach ($gamePackages as $gamePackage) {
      $results[] = $this->toGamePackage($gamePackage);
    }

    return $results;
  }

  /**
   * ゲームパッケージを取得する
   *
   * @param GamePackageId $gamePackageId
   * @throws Exception
   * @return GamePackage
   */
  public function get(GamePackageId $gamePackageId): GamePackage
  {
    try {
      $gamePackage = EloquentGamePackage::findOrFail($gamePackageId->getValue());
      $resource = $this->toGamePackage($gamePackage);
    } catch (ModelNotFoundException $e) {
      Log::Info($e->getMessage());
      throw new ModelNotFoundException(sprintf("ゲームパッケージID %d の情報が存在しません。", $gamePackageId->getValue()));
    }

    return $resource;
  }

  private function toGamePackage(EloquentGamePackage $gamePackage): ?GamePackage
  {
    if (!$gamePackage) {
      return null;
    }

    return new GamePackage([
      'gamePackageId'    => new GamePackageId($gamePackage->id),
      'description'      => new Description($gamePackage->description),
      'name'             => new Name($gamePackage->name),
    ]);
  }
}