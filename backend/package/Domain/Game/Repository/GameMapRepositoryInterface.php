<?php declare(strict_types=1);

namespace Package\Domain\Game\Repository;

interface GameMapRepositoryInterface {
  /**
   * @return array|null
   */
  public function list(): ?array;
}