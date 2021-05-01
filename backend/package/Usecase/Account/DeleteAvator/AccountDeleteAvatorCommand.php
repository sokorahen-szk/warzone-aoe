<?php declare(strict_types=1);

namespace Package\Usecase\Account\DeleteAvator;

class AccountDeleteAvatorCommand {
  public $userId;

  public function __construct(
    int $userId
  )
  {
    $this->userId = $userId;
  }
}