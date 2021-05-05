<?php declare(strict_types=1);

namespace Package\Application\Account\UpdateAvator;

use Package\Usecase\Account\UpdateAvator\AccountUpdateAvatorServiceInterface;
use Package\Usecase\Account\UpdateAvator\AccountUpdateAvatorCommand;
use Package\Domain\User\Repository\UserRepositoryInterface;
use Package\Domain\User\ValueObject\UserId;
use Package\Domain\User\ValueObject\FileImage;
use Package\Domain\User\Entity\UserAvator;

class AccountUpdateAvatorService implements AccountUpdateAvatorServiceInterface {
  private $userRepository;

  public function __construct(UserRepositoryInterface $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  public function handle(AccountUpdateAvatorCommand $command): void
  {
    $userAvator = new UserAvator([
      'userId'      => new UserId($command->userId),
      'fileImage'   => new FileImage($command->fileImage),
    ]);

    // TODO: ここは別にインフラ層のレイヤーでやるように書き直す予定。
    \Storage::disk('local')->putFileAs(
      '/public/profile',
      $userAvator->getFileImage()->getValue(),
      $userAvator->getUserAvatorImageName()
    );

    $this->userRepository->updateAvator($userAvator);
  }
}