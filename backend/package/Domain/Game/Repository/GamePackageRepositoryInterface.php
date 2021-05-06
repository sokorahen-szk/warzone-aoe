<?php declare(strict_types=1);

namespace Package\Domain\User\Repository;

interface GamePackageRepositoryInterface {
  /**
   * @return array|null
   */
  public function list(): ?array;
}