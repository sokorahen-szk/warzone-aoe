<?php declare(strict_types=1);

namespace Package\Usecase\Account\Game\GetList;

class AccountGameListCommand {
  public $userId;

  public function __construct(
    int $userId
  )
  {
    $this->userId = $userId;
  }
}