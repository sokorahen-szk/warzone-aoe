<?php declare(strict_types=1);

namespace Package\Application\Admin\User\Update;

use Package\Domain\User\Exceptions\CanNotRegisterUserException;
use Package\Domain\User\Repository\UserRepositoryInterface;
use Package\Domain\User\Service\UserServiceInterface;
use Package\Domain\User\ValueObject\Name;
use Package\Domain\User\ValueObject\UserId;
use Package\Usecase\Admin\User\Update\AdminUserUpdateCommand;
use Package\Usecase\Admin\User\Update\AdminUserUpdateServiceInterface;
use Exception;
use DB;
use Package\Domain\User\ValueObject\Email;
use Package\Domain\User\ValueObject\Password;
use Package\Domain\User\ValueObject\Status;
use Package\Domain\User\ValueObject\SteamId;
use Package\Domain\User\ValueObject\TwitterId;
use Package\Domain\User\ValueObject\WebSiteUrl;

class AdminUserUpdateService implements AdminUserUpdateServiceInterface {

    private $userRepository;
    private $userService;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserServiceInterface $userService
    )
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    public function handle(AdminUserUpdateCommand $command): void
    {
        $user = $this->userRepository->findUserById(new UserId($command->userId));

        if ($user->getName()->getValue() !== $command->userName) {
            $user->changeName(new Name($command->userName));

            if ($this->userService->exists($user)) {
                throw new CanNotRegisterUserException("ユーザ名が既に存在しています。");
            }
        }

        try {
			DB::beginTransaction();

            $user->changeSteamId(new SteamId($command->steamId));
            $user->changeTwitterId(new TwitterId($command->twitterId));
            $user->changeWebSiteUrl(new WebSiteUrl($command->webSiteUrl));
            $user->changeEmail(new Email($command->email));
            $user->changeStatus(new Status($command->status));

            if ($command->password) {
                $user->changePassword(new Password($command->password));
            }

            $this->userRepository->changeProfile($user);
            $this->userRepository->changeStatus($user->getId(), $user->getStatus());

			DB::commit();
        } catch (Exception $e) {
			DB::rollback();
			throw $e;
        }
    }
}