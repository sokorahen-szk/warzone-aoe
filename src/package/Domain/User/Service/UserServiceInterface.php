<?php declare(strict_types=1);

namespace Package\Domain\User\Service;

use Package\Domain\User\Entity\User;

interface UserServiceInterface {
  /**
   * @param User $user
   * @return bool
   */
  public function exists(User $user): bool;
}
