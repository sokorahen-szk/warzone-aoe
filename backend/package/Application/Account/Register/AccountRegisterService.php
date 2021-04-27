<?php declare(strict_types=1);

namespace Package\Application\Account\Register;

use Package\Usecase\Account\Register\AccountRegisterServiceInterface;
use Package\Usecase\Account\Register\AccountRegisterCommand;

use Package\Domain\User\Repository\UserRepositoryInterface;
use Package\Domain\User\Service\UserServiceInterface;

use Package\Domain\User\Entity\User;
use Package\Domain\User\ValueObject\Name;
use Package\Domain\User\ValueObject\Email;
use Package\Domain\User\ValueObject\PlayerId;
use Package\Domain\User\ValueObject\RoleId;
use Package\Domain\User\ValueObject\Password;

use Package\Domain\User\Exceptions\CanNotRegisterUserException;


class AccountRegisterService implements AccountRegisterServiceInterface {
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

  public function handle(AccountRegisterCommand $command)
  {
    $user = new User(
      null,
      null,
      new PlayerId(20000),
      null,
      new RoleId(3),
      new Name($command->userName),
      null,
      null,
      null,
      new Email($command->email),
      null,
      new Password($command->password)
    );

    if ($this->userService->exists($user)) {
      throw new CanNotRegisterUserException( "既に存在しています");
    }

    $this->userRepository->register($user);
  }
}