<?php declare(strict_types=1);

namespace Package\Infrastructure\Eloquent\User;

use Package\Domain\User\Repository\UserRepositoryInterface;

use Package\Domain\User\ValueObject\UserId;
use Package\Domain\User\ValueObject\Name;
use Package\Domain\User\Entity\User;
use Package\Domain\User\Entity\UserAvator;

use App\Models\UserModel as EloquentUser;

use Package\Infrastructure\Eloquent\Converter;

class UserRepository implements UserRepositoryInterface {
  /**
   * @param UserId $userId
   * @return User|null
   */
  public function findUserById(UserId $userId): ?User
  {
    $user = EloquentUser::where('id', $userId->getValue())
      ->with(['players', 'role'])
      ->first();

    if (!$user) {
      return null;
    }

    $role = Converter::role($user->role);
    $players = Converter::players($user->players);

    return Converter::user($user, $role, $players);
  }

  /**
   * @param Name $name
   * @return User|null
   */
  public function findByName(Name $name): ?User
  {
    $user = EloquentUser::where('name', $name->getValue())
    ->with(['players', 'role'])
    ->first();

    if (!$user) {
      return null;
    }

    $role = Converter::role($user->role);
    $players = Converter::players($user->players);

    return Converter::user($user, $role, $players);
  }

  /**
   * @param User $user
   * @return UserId
   */
  public function register(User $user): UserId
  {
    $user = EloquentUser::create([
      'role_id'     => $user->getRoleId()->getValue(),
      'name'        => $user->getName()->getValue(),
      'email'       => $user->getEmail()->getValidEmail(),
      'password'    => $user->getPassword()->getEncrypted(),
    ]);

    return new UserId($user->id);
  }

  /**
   * @param UserAvator $userAvator
   */
  public function updateAvator(UserAvator $userAvator): void
  {
    EloquentUser::where('id', $userAvator->getUserId()->getValue())
    ->update([
      'avator_image'  => $userAvator->getUserAvatorImageFilePath(),
    ]);
  }

  /**
   * @param UserId $userId
   */
  public function deleteAvator(UserId $userId): void
  {
    EloquentUser::where('id', $userId->getValue())
    ->update([
      'avator_image'  => null,
    ]);
  }

  /**
   * @param User $user
   */
  public function changeProfile(User $user): void
  {
    if ($user->getPassword()) {
      EloquentUser::where('id', $user->getId()->getValue())
      ->update([
        'name'          => $user->getName()->getValue(),
        'email'         => $user->getEmail()->getValidEmail(),
        'password'      => $user->getPassword()->getEncrypted(),
        'steam_id'      => $user->getSteamId()->getValue(),
        'twitter_id'    => $user->getTwitterId()->getValue(),
        'website_url'   => $user->getWebSiteUrl()->getValue(),
      ]);
    } else {
      EloquentUser::where('id', $user->getId()->getValue())
      ->update([
        'name'          => $user->getName()->getValue(),
        'email'         => $user->getEmail()->getValidEmail(),
        'steam_id'      => $user->getSteamId()->getValue(),
        'twitter_id'    => $user->getTwitterId()->getValue(),
        'website_url'   => $user->getWebSiteUrl()->getValue(),
      ]);
    }
  }

  /**
   * @param User $user
   */
  public function withdrawal(User $user): void
  {
    EloquentUser::where('id', $user->getId()->getValue())
    ->update([
      'status'  => $user->getStatus()->getValue(),
    ]);
  }
}
