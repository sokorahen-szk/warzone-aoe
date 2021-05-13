<?php declare(strict_types=1);

namespace Package\Usecase\Admin\RegisterRequest\Update;

class AdminRegisterRequestUpdateCommand {
  public $registerRequestId;
  public $userId;
  public $status;
  public $remarks;

  public function __construct(
    $registerRequestId,
    $userId,
    $status,
    $remarks
  )
  {
    $this->registerRequestId = $registerRequestId;
    $this->userId = $userId;
    $this->status = $status;
    $this->remarks = $remarks;
  }
}