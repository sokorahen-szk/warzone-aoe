<?php declare(strict_types=1);

namespace Package\Usecase\Account\ResetPassword;

interface AccountResetPasswordSendEmailServiceInterface {
  /**
   * @param AccountResetPasswordSendEmailCommand $command
   */
  public function handle(AccountResetPasswordSendEmailCommand $command);
}