<?php declare(strict_types=1);

namespace Package\Usecase\Account\GetInfo;

use Package\Usecase\Account\GetInfo\AccountGetInfoCommand;

interface AccountGetInfoServiceInterface {
  /**
   * @param UserGetInfoCommand $command
   */
  public function handle(AccountGetInfoCommand $command);
}