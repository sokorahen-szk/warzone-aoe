<?php declare(strict_types=1);

namespace Package\Infrastructure\Eloquent\Game;

use Package\Domain\Game\Repository\GamePackageRepositoryInterface;
use Package\Domain\Game\Entity\GamePackage;
use Package\Domain\Game\ValueObject\GamePackage\GamePackageId;
use App\Models\GamePackageModel as EloquentGamePackage;
use Exception;
use Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Package\Infrastructure\Eloquent\Converter;

class GamePackageRepository implements GamePackageRepositoryInterface {
  /**
   * ゲームパッケージ一覧を取得する
   *
   * @return GamePackage[]
   */
  public function list(): array
  {
    $gamePackages = EloquentGamePackage::get();

    return Converter::gamePackages($gamePackages);
  }

  /**
   * 特定のゲームパッケージを取得する
   *
   * @param GamePackageId $gamePackageId
   * @throws Exception
   * @return GamePackage
   */
  public function get(GamePackageId $gamePackageId): GamePackage
  {
    try {
      $gamePackage = EloquentGamePackage::findOrFail($gamePackageId->getValue());
      $resource = Converter::gamePackage($gamePackage);
    } catch (ModelNotFoundException $e) {
      Log::Info($e->getMessage());
      throw new ModelNotFoundException(sprintf("ゲームパッケージID %d の情報が存在しません。", $gamePackageId->getValue()));
    }

    return $resource;
  }
}