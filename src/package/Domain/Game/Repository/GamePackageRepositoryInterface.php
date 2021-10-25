<?php declare(strict_types=1);

namespace Package\Domain\Game\Repository;
use Package\Domain\Game\ValueObject\GamePackage\GamePackageId;
use Package\Domain\Game\Entity\GamePackage;

interface GamePackageRepositoryInterface {
  /**
   * @return array|null
   */
  public function list(): ?array;

  /**
   * ゲームパッケージを取得する
   *
   * @param GamePackageId $gamePackageId
   * @return GamePackage
   */
  public function get(GamePackageId $gamePackageId): GamePackage;
}