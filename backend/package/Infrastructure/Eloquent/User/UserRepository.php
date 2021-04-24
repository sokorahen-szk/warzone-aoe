<?php declare(strict_types=1);

namespace Package\Infrastructure\Eloquent\User;

use Package\Domain\User\Repository\UserRepositoryInterface;
use Package\Domain\User\ValueObject\UserId;
use Package\Domain\User\ValueObject\Name;
use Package\Domain\User\ValueObject\TwitterId;
use Package\Domain\User\ValueObject\WebSiteUrl;
use Package\Domain\User\ValueObject\AvatorImage;
use Package\Domain\User\ValueObject\Email;
use Package\Domain\User\ValueObject\Password;
use Package\Domain\User\ValueObject\Role\RoleId;
use Package\Domain\User\ValueObject\Role\RoleName;
use Package\Domain\User\ValueObject\Role\RoleLevel;
use Package\Domain\User\ValueObject\Player\PlayerId;
use Package\Domain\User\ValueObject\Player\PlayerName;
use Package\Domain\User\ValueObject\Player\Mu;
use Package\Domain\User\ValueObject\Player\Sigma;
use Package\Domain\User\ValueObject\Player\Rate;
use Package\Domain\User\ValueObject\Player\MinRate;
use Package\Domain\User\ValueObject\Player\MaxRate;
use Package\Domain\User\ValueObject\Player\Win;
use Package\Domain\User\ValueObject\Player\Defeat;
use Package\Domain\User\ValueObject\Player\Games;
use Package\Domain\User\ValueObject\Player\GamePackages;
use Package\Domain\User\ValueObject\Player\Datetime;
use Package\Domain\User\ValueObject\Player\Enabled;

use Package\Domain\User\Entity\User;
use Package\Domain\User\Entity\Role;
use Package\Domain\User\Entity\Player;

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

    $player = new Player(
      new PlayerId($user->player->id),
      new PlayerName($user->player->name),
      new Mu($user->player->mu),
      new Sigma($user->player->sigma),
      new Rate($user->player->rate),
      new MinRate($user->player->min_rate),
      new MaxRate($user->player->max_rate),
      new Win($user->player->win),
      new Defeat($user->player->defeat),
      new Games($user->player->games),
      new GamePackages($user->player->game_packages),
      new Datetime($user->player->joined_at),
      new Datetime($user->player->last_game_at),
      new Enabled($user->player->enabled)
    );

    return new User(
      new UserId($user->id),
      $player,
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