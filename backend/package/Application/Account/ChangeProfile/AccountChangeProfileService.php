<?php declare(strict_types=1);

namespace Package\Application\Account\ChangeProfile;

use Package\Usecase\Account\ChangeProfile\AccountChangeProfileServiceInterface;
use Package\Usecase\Account\ChangeProfile\AccountChangeProfileCommand;
use Package\Domain\User\Repository\UserRepositoryInterface;
use Package\Domain\User\Service\UserServiceInterface;

use Package\Domain\User\ValueObject\UserId;
use Package\Domain\User\ValueObject\Name;
use Package\Domain\User\ValueObject\SteamId;
use Package\Domain\User\ValueObject\TwitterId;
use Package\Domain\User\ValueObject\WebSiteURL;
use Package\Domain\User\ValueObject\Email;
use Package\Domain\User\ValueObject\Password;

use Package\Domain\User\Entity\User;

use Package\Domain\User\Exceptions\CanNotRegisterUserException;

class AccountChangeProfileService implements AccountChangeProfileServiceInterface {
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

  public function handle(AccountChangeProfileCommand $command): void
  {
    $user = $this->userRepository->findUserById(new UserId($command->userId));

    if ($user->getName()->getValue() !== $command->userName) {
      $user->changeName(new Name($command->userName));

      if ($this->userService->exists($user)) {
        throw new CanNotRegisterUserException("ユーザ名が既に存在しています。");
      }
    }

    $user->changeSteamId(new SteamId($command->steamId));
    $user->changeTwitterId(new TwitterId($command->twitterId));
    $user->changeWebSiteURL(new WebSiteURL($command->webSiteURL));
    $user->changeEmail(new Email($command->email));

    if ($command->password) {
      $user->changePassword(new Password($command->password));
    }

    $this->userRepository->changeProfile($user);
  }
}