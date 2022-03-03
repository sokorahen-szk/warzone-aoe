<?php declare(strict_types=1);

namespace Package\Usecase\Admin\Game\Update;

interface AdminGameUpdateServiceInterface {
  public function handle(AdminGameUpdateCommand $command);
}
