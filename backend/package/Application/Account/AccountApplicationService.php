<?php declare(strict_types=1);

namespace Package\Application\Account;

use Package\Domain\User\Repository\UserRepositoryInterface;

class AccountApplicationService {
  private $userRepository;

  public function __construct(UserRepositoryInterface $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  
}