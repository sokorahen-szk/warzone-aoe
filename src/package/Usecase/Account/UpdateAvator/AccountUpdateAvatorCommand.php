<?php declare(strict_types=1);

namespace Package\Usecase\Account\UpdateAvator;

class AccountUpdateAvatorCommand {
  public $userId;
  public $fileImage;

  public function __construct(
    int $userId,
    $fileImage
  )
  {
    $this->userId = $userId;
    $this->fileImage = $fileImage;
  }
}