<?php declare(strict_types=1);

namespace Package\Usecase\Account\UpdateAvator;

use Package\Usecase\Account\UpdateAvator\AccountUpdateAvatorCommand;

interface AccountUpdateAvatorServiceInterface {
  /**
   * @param AccountUpdateAvatorCommand $command
   */
  public function handle(AccountUpdateAvatorCommand $command);
}