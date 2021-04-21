<?php declare(strict_types=1);

namespace Package\Infrastructure\Eloquent\User;

use Package\Domain\User\Repository\UserRepositoryInterface;
use Package\Domain\User\Entity\User;
use Package\Domain\User\ValueObject\UserId;
use Package\Domain\User\ValueObject\PlayerId;
use Package\Domain\User\ValueObject\RoleId;
use Package\Domain\User\ValueObject\Name;
use Package\Domain\User\ValueObject\TwitterId;
use Package\Domain\User\ValueObject\WebSiteUrl;
use Package\Domain\User\ValueObject\AvatorImage;
use Package\Domain\User\ValueObject\Email;
use Package\Domain\User\ValueObject\Password;

use App\Models\User as EloquentUser;

class UserRepository implements UserRepositoryInterface {
  /**
   * @param UserId $userId
   * @return User|null
   */
  public function findUserById(UserId $userId): ?User
  {
    $user = EloquentUser::find($userId->getValue())->first();

    if (!$user) {
      return null;
    }

    return new User(
      new UserId($user->id),
      new PlayerId($user->player_id),
      new RoleId($user->role_id),
      new Name($user->name),
      new TwitterId($user->twitter_id),
      new WebSiteUrl($user->website_url),
      new AvatorImage($user->avator_image),
      new Email($user->password),
      null
    );
  }
}