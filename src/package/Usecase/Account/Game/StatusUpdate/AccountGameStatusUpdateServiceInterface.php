<?php declare(strict_types=1);

namespace Package\Usecase\Account\Game\StatusUpdate;

interface AccountGameStatusUpdateServiceInterface {
  public function handle(AccountGameStatusUpdateCommand $command): void;
}