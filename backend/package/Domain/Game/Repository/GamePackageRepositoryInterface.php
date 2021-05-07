<?php declare(strict_types=1);

namespace Package\Domain\Game\Repository;

interface GamePackageRepositoryInterface {
  /**
   * @return array|null
   */
  public function list(): ?array;
}