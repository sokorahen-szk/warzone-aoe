<?php declare(strict_types=1);

namespace Package\Application\Admin\User\Update;

use Package\Domain\User\Repository\UserRepositoryInterface;
use Package\Usecase\Admin\User\Update\AdminUserUpdateCommand;
use Package\Usecase\Admin\User\Update\AdminUserUpdateServiceInterface;

class AdminUserUpdateService implements AdminUserUpdateServiceInterface {

    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(AdminUserUpdateCommand $command): void
    {
        //
    }
}