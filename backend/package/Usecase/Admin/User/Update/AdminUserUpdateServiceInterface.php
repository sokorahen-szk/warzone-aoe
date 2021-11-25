<?php declare(strict_types=1);

namespace Package\Usecase\Admin\User\Update;

interface AdminUserUpdateServiceInterface {
  public function handle(AdminUserUpdateCommand $command);
}
