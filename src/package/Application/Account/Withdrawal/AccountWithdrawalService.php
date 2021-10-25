<?php declare(strict_types=1);

namespace Package\Application\Account\Withdrawal;

use Package\Usecase\Account\Withdrawal\AccountWithdrawalServiceInterface;
use Package\Usecase\Account\Withdrawal\AccountWithdrawalCommand;
use Package\Domain\User\Repository\UserRepositoryInterface;
use Package\Domain\User\ValueObject\UserId;
use Package\Domain\User\ValueObject\FileImage;
use Package\Domain\User\Entity\UserAvator;

class AccountWithdrawalService implements AccountWithdrawalServiceInterface {
  private $userRepository;

  public function __construct(UserRepositoryInterface $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  public function handle(AccountWithdrawalCommand $command): void
  {
    $user = $this->userRepository->findUserById(new UserId($command->userId));

    $user->getStatus()->changeWithdrawal();

    $this->userRepository->withdrawal($user);
  }
}