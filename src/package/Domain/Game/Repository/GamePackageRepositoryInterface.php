<?php declare(strict_types=1);

namespace Package\Domain\Game\Repository;
use Package\Domain\Game\ValueObject\GamePackage\GamePackageId;
use Package\Domain\Game\Entity\GamePackage;

interface GamePackageRepositoryInterface {
  /**
   * ゲームパッケージ一覧を取得する
   *
   * @return GamePackage[]
   */
  public function list(): array;

  /**
   * 特定のゲームパッケージを取得する
   *
   * @param GamePackageId $gamePackageId
   * @return GamePackage
   */
  public function get(GamePackageId $gamePackageId): GamePackage;
}