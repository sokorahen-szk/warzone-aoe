<?php declare(strict_types=1);

namespace Package\Application\Admin\User\ListData;

use Package\Domain\User\Repository\UserRepositoryInterface;
use Package\Usecase\Admin\User\ListData\AdminUserListServiceInterface;
use Package\Usecase\Admin\User\ListData\AdminUserListData;

class AdminUserListService implements AdminUserListServiceInterface {

    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(): AdminUserListData
    {
        $users = $this->userRepository->list();
        return new AdminUserListData($users);
    }
}