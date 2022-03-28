<?php declare(strict_types=1);

namespace Package\Usecase\Account\Withdrawal;

use Package\Usecase\Account\Withdrawal\AccountWithdrawalCommand;

interface AccountWithdrawalServiceInterface {
  /**
   * @param AccountWithdrawalCommand $command
   */
  public function handle(AccountWithdrawalCommand $command);
}