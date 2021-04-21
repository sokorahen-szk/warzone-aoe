<?php declare(strict_types=1);

namespace Package\Usecase\User\GetInfo;

class UserGetInfoCommand {
  public $userId;

  public function __construct(string $userId)
  {
    $this->userId = $userId;
  }
}