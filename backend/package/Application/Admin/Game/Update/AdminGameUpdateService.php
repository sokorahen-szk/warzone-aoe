<?php declare(strict_types=1);

namespace Package\Application\Admin\Game\Update;

use Package\Usecase\Admin\Game\Update\AdminGameUpdateServiceInterface;
use Package\Usecase\Admin\Game\Update\AdminGameUpdateCommand;

class AdminGameUpdateService implements AdminGameUpdateServiceInterface {
    public function __construct()
    {
        //
    }

    public function handle(AdminGameUpdateCommand $command)
    {
        //
    }
}