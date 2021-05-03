<?php declare(strict_types=1);

namespace Package\Usecase\Account\ChangeProfile;

use Package\Usecase\Account\ChangeProfile\AccountChangeProfileCommand;

interface AccountChangeProfileServiceInterface {
  /**
   * @param AccountChangeProfileCommand $command
   */
  public function handle(AccountChangeProfileCommand $command);
}