<?php declare(strict_types=1);

namespace Package\Domain\Game\Repository;

use Package\Domain\Game\ValueObject\Id as GamePackageId;

interface GameMapRepositoryInterface {
  /**
   * @return array|null
   */
  public function list(GamePackageId $gamePackageId): ?array;
}