<?php declare(strict_types=1);

namespace Package\Application\Account\Register;

use Package\Usecase\Account\Register\AccountRegisterServiceInterface;
use Package\Usecase\Account\Register\AccountRegisterCommand;

use Package\Domain\User\Repository\UserRepositoryInterface;
use Package\Domain\User\Repository\PlayerRepositoryInterface;
use Package\Domain\User\Repository\RegisterRequestRepositoryInterface;
use Package\Domain\User\Service\UserServiceInterface;

use Package\Domain\User\Entity\User;
use Package\Domain\User\Entity\Player;
use Package\Domain\User\Entity\RegisterRequest;

use Package\Domain\User\ValueObject\Name;
use Package\Domain\User\ValueObject\Email;
use Package\Domain\User\ValueObject\Role\RoleId;
use Package\Domain\User\ValueObject\Password;

use Package\Domain\User\ValueObject\UserId;
use Package\Domain\User\ValueObject\Player\PlayerName;
use Package\Domain\User\ValueObject\Player\GamePackageIds;
use Package\Domain\Game\ValueObject\GamePackage\GamePackageId;

use Package\Domain\User\Exceptions\CanNotRegisterUserException;

class AccountRegisterService implements AccountRegisterServiceInterface {
  private $userRepository;
  private $playerRepository;
  private $registerRequestRepository;
  private $userService;

  public function __construct(
    UserRepositoryInterface $userRepository,
    PlayerRepositoryInterface $playerRepository,
    RegisterRequestRepositoryInterface $registerRequestRepository,
    UserServiceInterface $userService
  )
  {
    $this->userRepository = $userRepository;
    $this->playerRepository = $playerRepository;
    $this->registerRequestRepository = $registerRequestRepository;
    $this->userService = $userService;
  }

  public function handle(AccountRegisterCommand $command)
  {
    $user = new User([
      'roleId'      => new RoleId(4),
      'name'        => new Name($command->userName),
      'email'       => new Email($command->email),
      'password'    => new Password($command->password),
    ]);

    if ($this->userService->exists($user)) {
      throw new CanNotRegisterUserException("ユーザ名が既に存在しています。");
    }

    $userId = $this->userRepository->register($user);
    $gamePackageIds = new GamePackageIds($command->gamePackageIds);

    foreach ($gamePackageIds->getList() as $gamePackageIdInt) {
      $player = new Player([
        'userId'          => $userId,
        'playerName'      => new PlayerName($command->playerName),
        'gamePackageId'   => new GamePackageId($gamePackageIdInt),
      ]);

      $this->playerRepository->register($player);
    }

    $this->registerRequestRepository->register(new RegisterRequest([
        'userId' => $userId,
    ]));
  }
}