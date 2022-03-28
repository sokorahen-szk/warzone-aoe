<?php declare(strict_types=1);

namespace Package\Usecase\Admin\User\Create;

interface AdminUserCreateServiceInterface {
  public function handle(AdminUserCreateCommand $command): void;
}
