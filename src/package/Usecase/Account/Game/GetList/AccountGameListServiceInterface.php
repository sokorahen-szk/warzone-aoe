<?php declare(strict_types=1);

namespace Package\Usecase\Account\Game\GetList;

interface AccountGameListServiceInterface {
  public function handle(AccountGameListCommand $command): AccountGameListData;
}