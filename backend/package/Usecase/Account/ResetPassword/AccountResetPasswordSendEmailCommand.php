<?php declare(strict_types=1);

namespace Package\Usecase\Account\ResetPassword;

class AccountResetPasswordSendEmailCommand {
  public $email;

  public function __construct(
    string $email
  )
  {
    $this->email = $email;
  }
}