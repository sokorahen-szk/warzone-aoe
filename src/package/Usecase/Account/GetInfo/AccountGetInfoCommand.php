<?php declare(strict_types=1);

namespace Package\Usecase\Account\GetInfo;

class AccountGetInfoCommand {
  public $userId;

  public function __construct(string $userId)
  {
    $this->userId = $userId;
  }
}