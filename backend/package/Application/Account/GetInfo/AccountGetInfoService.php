<?php declare(strict_types=1);

namespace Package\Application\Account\GetInfo;

use Package\Usecase\Account\GetInfo\AccountGetInfoServiceInterface;
use Package\Usecase\Account\GetInfo\AccountGetInfoCommand;
use Package\Domain\User\Repository\UserRepositoryInterface;
use Package\Domain\User\ValueObject\UserId;

class AccountGetInfoService implements AccountGetInfoServiceInterface {
  private $userRepository;

  public function __construct(UserRepositoryInterface $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  public function handle(AccountGetInfoCommand $command)
  {
    $userId = new UserId($command->userId);
    var_dump($userId->getValue());
  }
}