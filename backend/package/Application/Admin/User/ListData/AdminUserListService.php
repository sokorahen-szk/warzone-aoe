<?php declare(strict_types=1);

namespace Package\Application\Admin\User\ListData;

use Package\Usecase\Admin\User\ListData\AdminUserListServiceInterface;
use Package\Usecase\Admin\User\ListData\AdminUserListData;

class AdminUserListService implements AdminUserListServiceInterface {
    public function __construct()
    {
        //
    }

    public function handle(): AdminUserListData
    {
        return new AdminUserListData([]);
    }
}