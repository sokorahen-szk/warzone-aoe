<?php declare(strict_types=1);

namespace Package\Domain\User\Repository;

use Package\Domain\User\ValueObject\UserId;
use Package\Domain\User\ValueObject\Name;
use Package\Domain\User\Entity\User;
use Package\Domain\User\Entity\UserAvator;
use Package\Domain\System\Entity\Paginator;
use Package\Domain\User\ValueObject\Role\RoleId;
use Package\Domain\User\ValueObject\Status as UserStatus;

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
   * @param UserId $userId
   * @param UserStatus $userStatus
   */
  public function changeStatus(UserId $userId, UserStatus $userStatus): void;

  /**
   * @param UserId $userId
   * @param RoleId $roleId
   */
  public function changeRoleId(UserId $userId, RoleId $roleId): void;

  /**
   * @param Paginator $paginator
   * @return User[]
   */
  public function list(Paginator $paginator): array;

  /**
   * @return int
   */
  public function listCount(): int;
}
