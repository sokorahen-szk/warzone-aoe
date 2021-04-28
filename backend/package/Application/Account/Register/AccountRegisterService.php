<?php declare(strict_types=1);

namespace Package\Application\Account\Register;

use Package\Usecase\Account\Register\AccountRegisterServiceInterface;
use Package\Usecase\Account\Register\AccountRegisterCommand;

use Package\Domain\User\Repository\UserRepositoryInterface;
use Package\Domain\User\Repository\PlayerRepositoryInterface;
use Package\Domain\User\Service\UserServiceInterface;

use Package\Domain\User\Entity\User;
use Package\Domain\User\Entity\Player;

use Package\Domain\User\ValueObject\Name;
use Package\Domain\User\ValueObject\Email;
use Package\Domain\User\ValueObject\RoleId;
use Package\Domain\User\ValueObject\Password;

use Package\Domain\User\ValueObject\Player\PlayerName;
use Package\Domain\User\ValueObject\Player\GamePackages;
use Package\Domain\User\ValueObject\Player\PlayerId;

use Package\Domain\User\Exceptions\CanNotRegisterUserException;


class AccountRegisterService implements AccountRegisterServiceInterface {
  private $userRepository;
  private $playerRepository;
  private $userService;

  public function __construct(
    UserRepositoryInterface $userRepository,
    PlayerRepositoryInterface $playerRepository,
    UserServiceInterface $userService
  )
  {
    $this->userRepository = $userRepository;
    $this->playerRepository = $playerRepository;
    $this->userService = $userService;
  }

  public function handle(AccountRegisterCommand $command)
  {
    $player = new Player([
      'playerName'    => new PlayerName($command->playerName),
      'gamePackages'  => new GamePackages($command->gamePackages),
    ]);

    $playerId = $this->playerRepository->register($player);

    $user = new User([
      'playerId'    => $playerId,
      'roleId'      => new RoleId(3),
      'name'        => new Name($command->userName),
      'email'       => new Email($command->email),
      'password'    => new Password($command->password),
    ]);

    if ($this->userService->exists($user)) {
      throw new CanNotRegisterUserException( "既に存在しています");
    }

    $this->userRepository->register($user);
  }
}