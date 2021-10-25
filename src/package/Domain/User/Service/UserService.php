<?php declare(strict_types=1);

namespace Package\Domain\User\Service;

use Package\Domain\User\Repository\UserRepositoryInterface;
use Package\Domain\User\Entity\User;

class UserService implements UserServiceInterface {
  private $userRepository;

  public function __construct(UserRepositoryInterface $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  public function exists(User $user): bool
  {
    $found = $this->userRepository->findByName($user->getName());

    return $found != null;
  }
}
