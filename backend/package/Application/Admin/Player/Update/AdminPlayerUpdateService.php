<?php declare(strict_types=1);

namespace Package\Application\Admin\Player\Update;

use Package\Usecase\Admin\Player\Update\AdminPlayerUpdateCommand;
use Package\Usecase\Admin\Player\Update\AdminPlayerUpdateServiceInterface;

class AdminPlayerUpdateService implements AdminPlayerUpdateServiceInterface {

    public function __construct(
    )
    {
        //
    }

    public function handle(AdminPlayerUpdateCommand $command)
    {
        //
    }
}