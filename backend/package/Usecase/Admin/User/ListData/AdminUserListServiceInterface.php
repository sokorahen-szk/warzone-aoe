<?php declare(strict_types=1);

namespace Package\Usecase\Admin\User\ListData;

interface AdminUserListServiceInterface {
  public function handle(AdminUserListCommand $command): AdminUserListData;
}
