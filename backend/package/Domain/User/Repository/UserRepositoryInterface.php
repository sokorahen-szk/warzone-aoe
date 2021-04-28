<?php declare(strict_types=1);

namespace Package\Domain\User\Repository;

use Package\Domain\User\ValueObject\UserId;
use Package\Domain\User\ValueObject\Name;
use Package\Domain\User\Entity\User;

interface UserRepositoryInterface {
  /**
   * @param UserId $userId
   * @return User|null
   */
  public function findUserById(UserId $userId): ?User;

  /**
   * @param Name $name
   * @return User|null
   */
  public function findByName(Name $name): ?User;

  /**
   * @param User $user
   */
  public function register(User $user): void;
}