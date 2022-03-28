<?php declare(strict_types=1);

namespace Package\Usecase\Admin\RegisterRequest\Update;

interface AdminRegisterRequestUpdateServiceInterface {
  public function handle(AdminRegisterRequestUpdateCommand $command): void;
}