<?php declare(strict_types=1);

namespace Package\Infrastructure\Eloquent\User;

use Package\Domain\User\Repository\UserRepositoryInterface;
use Package\Domain\User\ValueObject\UserId;
use Package\Domain\User\ValueObject\PlayerId;
use Package\Domain\User\ValueObject\Name;
use Package\Domain\User\ValueObject\TwitterId;
use Package\Domain\User\ValueObject\WebSiteUrl;
use Package\Domain\User\ValueObject\AvatorImage;
use Package\Domain\User\ValueObject\Email;
use Package\Domain\User\ValueObject\Password;
use Package\Domain\User\ValueObject\Role\RoleId;
use Package\Domain\User\ValueObject\Role\RoleName;
use Package\Domain\User\ValueObject\Role\RoleLevel;


use Package\Domain\User\Entity\User;
use Package\Domain\User\Entity\Role;

use App\Models\UserModel as EloquentUser;

class UserRepository implements UserRepositoryInterface {
  /**
   * @param UserId $userId
   * @return User|null
   */
  public function findUserById(UserId $userId): ?User
  {
    $user = EloquentUser::find($userId->getValue())
      ->with(['player', 'role'])
      ->first();

    if (!$user) {
      return null;
    }

    $role = new Role(
      new RoleId($user->role->id),
      new RoleName($user->role->name),
      new RoleLevel($user->role->level),
    );

    return new User(
      new UserId($user->id),
      new PlayerId($user->player_id),
      $role,
      new Name($user->name),
      new TwitterId($user->twitter_id),
      new WebSiteUrl($user->website_url),
      new AvatorImage($user->avator_image),
      new Email($user->email),
      null
    );
  }
}