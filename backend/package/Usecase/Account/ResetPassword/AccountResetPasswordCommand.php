<?php declare(strict_types=1);

namespace Package\Usecase\Account\ResetPassword;

class AccountResetPasswordCommand {
  public $password;
  public $token;

  public function __construct(
    string $password,
    string $token
  )
  {
    $this->password = $password;
    $this->token = $token;
  }
}