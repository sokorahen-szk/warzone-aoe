<?php declare(strict_types=1);

namespace Package\Application\Player\GetProfile;

use Package\Domain\User\Repository\UserRepositoryInterface;

use Package\Usecase\Player\GetProfile\PlayerGetProfileServiceInterface;
use Package\Usecase\Player\GetProfile\PlayerGetProfileData;
use Package\Usecase\Player\GetProfile\PlayerGetProfileCommand;

use Package\Domain\User\ValueObject\UserId;

class PlayerGetProfileService implements PlayerGetProfileServiceInterface {
  private $userRepository;

  public function __construct(UserRepositoryInterface $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  public function handle(PlayerGetProfileCommand $command): PlayerGetProfileData
  {
    $userId = new UserId($command->userId);
    $user = $this->userRepository->findUserById($userId);
    if (is_null($user)) {
      return null;
    }
	return new PlayerGetProfileData($user);
  }
}