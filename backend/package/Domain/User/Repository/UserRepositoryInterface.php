<?php declare(strict_types=1);

namespace Package\Domain\User\Repository;

use Package\Domain\User\ValueObject\UserId;
use Package\Domain\User\Entity\User;

interface UserRepositoryInterface {
  /**
   * @param UserId $userId
   * @return User|null
   */
  public function findUserById(UserId $userId): ?User;
}