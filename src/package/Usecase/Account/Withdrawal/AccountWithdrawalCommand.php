<?php declare(strict_types=1);

namespace Package\Usecase\Account\Withdrawal;

class AccountWithdrawalCommand {
  public $userId;

  public function __construct(
    int $userId
  )
  {
    $this->userId = $userId;
  }
}