<?php declare(strict_types=1);

namespace Package\Usecase\Account\DeleteAvator;

use Package\Usecase\Account\DeleteAvator\AccountDeleteAvatorCommand;

interface AccountDeleteAvatorServiceInterface {
  /**
   * @param AccountDeleteAvatorCommand $command
   */
  public function handle(AccountDeleteAvatorCommand $command);
}