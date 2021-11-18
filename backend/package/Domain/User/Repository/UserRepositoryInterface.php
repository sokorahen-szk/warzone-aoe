<?php declare(strict_types=1);

namespace Package\Domain\User\Repository;

use Package\Domain\User\ValueObject\UserId;
use Package\Domain\User\ValueObject\Name;
use Package\Domain\User\Entity\User;
use Package\Domain\User\Entity\UserAvator;

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

  /**
   * @param User $user
   */
  public function changeProfile(User $user): void;

  /**
   * @param UserAvator $userAvator
   */
  public function updateAvator(UserAvator $userAvator): void;

  /**
   * @param UserId $userId
   */
  public function deleteAvator(UserId $userId): void;

  /**
   * @param User $user
   */
  public function withdrawal(User $user): void;

  /**
   * @return User[]
   */
  public function list(): array;
}
