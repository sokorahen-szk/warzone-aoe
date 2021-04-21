<?php declare(strict_types=1);

namespace Package\Usecase\User\GetInfo;

use Package\Usecase\User\GetInfo\UserGetInfoCommand;

interface UserGetInfoServiceInterface {
  /**
   * @param UserGetInfoCommand $command
   */
  public function handle(UserGetInfoCommand $command);
}