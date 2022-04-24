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
use Package\Domain\User\Repository\PlayerRepositoryInterface;
use Package\Domain\User\ValueObject\Email;
use Package\Domain\User\ValueObject\Password;
use Package\Domain\User\ValueObject\Player\GamePackages;
use Package\Domain\User\ValueObject\Role\RoleId;
use Package\Domain\User\ValueObject\Status;
use Package\Domain\User\ValueObject\SteamId;
use Package\Domain\User\ValueObject\TwitterId;
use Package\Domain\User\ValueObject\WebSiteUrl;
use Package\Domain\User\ValueObject\Player\Enabled;

class AdminUserUpdateService implements AdminUserUpdateServiceInterface {

    private $userRepository;
    private $userService;
    private $playerRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserServiceInterface $userService,
        PlayerRepositoryInterface $playerRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
        $this->playerRepository = $playerRepository;
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
            $user->changeRoleId(new RoleId($command->roleId));

            $player = $user->getPlayer();
            $player->updateGamePackages(new GamePackages($command->gamePackages));

            // ユーザのステータスを[有効]以外のに変更した場合、Playerの状態もdisabledに変更する。
            $enabled = new Enabled(Enabled::PLAYER_ACCOUNT_DISABLED);
            if ($user->isAvailable()) {
                $enabled = new Enabled(Enabled::PLAYER_ACCOUNT_ENABLED);
            }
            $player->changeEnabled($enabled);
            $this->playerRepository->updateEnabled($player);

            if ($command->password) {
                $user->changePassword(new Password($command->password));
            }

            $this->userRepository->changeProfile($user);
            $this->userRepository->changeStatus($user->getId(), $user->getStatus());
            $this->userRepository->changeRoleId($user->getId(), $user->getRoleId());
            $this->playerRepository->updateGamePackage($player->getPlayerId(), $player->getGamePackages());

			DB::commit();
        } catch (Exception $e) {
			DB::rollback();
			throw $e;
        }
    }
}