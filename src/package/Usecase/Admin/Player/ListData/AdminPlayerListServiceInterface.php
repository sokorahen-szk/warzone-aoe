<?php declare(strict_types=1);

namespace Package\Usecase\Admin\Player\ListData;

interface AdminPlayerListServiceInterface {
  public function handle(AdminPlayerListCommand $command): AdminPlayerListData;
}
