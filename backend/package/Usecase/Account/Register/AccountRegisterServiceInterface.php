<?php declare(strict_types=1);

namespace Package\Usecase\Account\Register;

use Package\Usecase\Account\Register\AccountRegisterCommand;

interface AccountRegisterServiceInterface {
  /**
   * @param AccountRegisterCommand $command
   */
  public function handle(AccountRegisterCommand $command);
}