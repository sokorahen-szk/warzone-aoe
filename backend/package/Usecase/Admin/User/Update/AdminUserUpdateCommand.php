<?php declare(strict_types=1);

namespace Package\Usecase\Admin\User\Update;

class AdminUserUpdateCommand {
  public $userId;
  public $status;

  public function __construct(
    int $userId,
    ?int $status
  )
  {
    $this->userId = $userId;
    $this->status = $status;
  }
}