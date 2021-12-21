<?php declare(strict_types=1);

namespace Package\Application\Admin\User\Create;

use Package\Domain\User\Repository\UserRepositoryInterface;
use Package\Usecase\Admin\User\Create\AdminUserCreateCommand;
use Package\Usecase\Admin\User\Create\AdminUserCreateServiceInterface;

class AdminUserCreateService implements AdminUserCreateServiceInterface {

    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(AdminUserCreateCommand $command): void
    {
        //
    }
}