<?php declare(strict_types=1);

namespace Package\Application\Account\DeleteAvator;

use Package\Usecase\Account\DeleteAvator\AccountDeleteAvatorServiceInterface;
use Package\Usecase\Account\DeleteAvator\AccountDeleteAvatorCommand;
use Package\Domain\User\Repository\UserRepositoryInterface;
use Package\Domain\User\ValueObject\UserId;

class AccountDeleteAvatorService implements AccountDeleteAvatorServiceInterface {
  private $userRepository;

  public function __construct(UserRepositoryInterface $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  public function handle(AccountDeleteAvatorCommand $command): void
  {
    $userId = new UserId($command->userId);
    $this->userRepository->deleteAvator($userId);
  }
}