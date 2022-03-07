<?php declare(strict_types=1);

namespace Package\Usecase\Account\ResetPassword;

interface AccountResetPasswordServiceInterface {
  /**
   * @param AccountResetPasswordCommand $command
   */
  public function handle(AccountResetPasswordCommand $command);
}