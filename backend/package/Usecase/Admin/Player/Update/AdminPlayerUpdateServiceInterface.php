<?php declare(strict_types=1);

namespace Package\Usecase\Admin\Player\Update;

interface AdminPlayerUpdateServiceInterface {
  public function handle(AdminPlayerUpdateCommand $command);
}
