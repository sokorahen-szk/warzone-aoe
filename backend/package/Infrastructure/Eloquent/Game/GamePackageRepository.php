<?php declare(strict_types=1);

namespace Package\Infrastructure\Eloquent\Game;

use Package\Domain\Game\Repository\GamePackageRepositoryInterface;
use Package\Domain\Game\Entity\GamePackage;
use Package\Domain\Game\ValueObject\Id as GamePackageId;
use Package\Domain\Game\ValueObject\Description as GamePackageDescription;
use Package\Domain\Game\ValueObject\Name as GamePackageName;
use App\Models\GamePackageModel as EloquentGamePackage;

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
      $results[] = new GamePackage([
        'gamePackageId'               => new GamePackageId($gamePackage->id),
        'gamePackageDescription'      => new GamePackageDescription($gamePackage->description),
        'gamePackageName'             => new GamePackageName($gamePackage->name),
      ]);
    }

    return $results;
  }
}