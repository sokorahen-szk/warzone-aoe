<?php declare(strict_types=1);

namespace Package\Application\Account\GetInfo;

use Package\Usecase\Account\GetInfo\AccountGetInfoServiceInterface;
use Package\Usecase\Account\GetInfo\AccountGetInfoCommand;
use Package\Usecase\Account\GetInfo\AccountData;
use Package\Domain\User\Repository\UserRepositoryInterface;
use Package\Domain\User\ValueObject\UserId;

class AccountGetInfoService implements AccountGetInfoServiceInterface {
  private $userRepository;

  public function __construct(UserRepositoryInterface $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  public function handle(AccountGetInfoCommand $command): AccountData
  {
    $userId = new UserId($command->userId);
    $user = $this->userRepository->findUserById($userId);
    if (is_null($user)) {
        return null;
    }

    return new AccountData($user);
  }
}