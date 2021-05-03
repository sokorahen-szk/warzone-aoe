<?php declare(strict_types=1);

namespace Package\Infrastructure\Eloquent\User;

use Package\Domain\User\Repository\UserRepositoryInterface;
use Package\Domain\User\ValueObject\UserId;
use Package\Domain\User\ValueObject\Name;
use Package\Domain\User\ValueObject\SteamId;
use Package\Domain\User\ValueObject\TwitterId;
use Package\Domain\User\ValueObject\WebSiteUrl;
use Package\Domain\User\ValueObject\AvatorImage;
use Package\Domain\User\ValueObject\Email;
use Package\Domain\User\ValueObject\Status;
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
use Package\Domain\User\Entity\UserAvator;

use App\Models\UserModel as EloquentUser;

class UserRepository implements UserRepositoryInterface {
  /**
   * @param UserId $userId
   * @return User|null
   */
  public function findUserById(UserId $userId): ?User
  {
    $user = EloquentUser::where('id', $userId->getValue())
      ->with(['player', 'role'])
      ->first();

    if (!$user) {
      return null;
    }

    $role = new Role([
      'roleId'        => new RoleId($user->role->id),
      'roleName'      => new RoleName($user->role->name),
      'roleLevel'     => new RoleLevel($user->role->level),
    ]);

    $player = new Player([
      'playerId'      => new PlayerId($user->player->id),
      'playerName'    => new PlayerName($user->player->name),
      'mu'            => new Mu($user->player->mu),
      'sigma'         => new Sigma($user->player->sigma),
      'rate'          => new Rate($user->player->rate),
      'minRate'       => new MinRate($user->player->min_rate),
      'maxRate'       => new MaxRate($user->player->max_rate),
      'win'           => new Win($user->player->win),
      'defeat'        => new Defeat($user->player->defeat),
      'games'         => new Games($user->player->games),
      'gamePackages'  => new GamePackages($user->player->game_packages),
      'joinedAt'      => new Datetime($user->player->joined_at),
      'lastGameAt'    => new Datetime($user->player->last_game_at),
      'enabled'       => new Enabled($user->player->enabled)
    ]);

    return new User([
      'id'            => new UserId($user->id),
      'player'        => $player,
      'playerId'      => new PlayerId($user->player_id),
      'role'          => $role,
      'roleId'        => new RoleId($user->role_id),
      'name'          => new Name($user->name),
      'steamId'       => new SteamId($user->steam_id),
      'twitterId'     => new TwitterId($user->twitter_id),
      'webSiteUrl'    => new WebSiteUrl($user->website_url),
      'avatorImage'   => new AvatorImage($user->avator_image),
      'email'         => new Email($user->email),
      'status'        => new Status($user->status),
    ]);
  }

  /**
   * @param Name $name
   * @return User|null
   */
  public function findByName(Name $name): ?User
  {
    $user = EloquentUser::where('name', $name->getValue())
    ->with(['player', 'role'])
    ->first();

    if (!$user) {
      return null;
    }

    $role = new Role([
      'roleId'        => new RoleId($user->role->id),
      'roleName'      => new RoleName($user->role->name),
      'roleLevel'     => new RoleLevel($user->role->level),
    ]);

    $player = new Player([
      'playerId'      => new PlayerId($user->player->id),
      'playerName'    => new PlayerName($user->player->name),
      'mu'            => new Mu($user->player->mu),
      'sigma'         => new Sigma($user->player->sigma),
      'rate'          => new Rate($user->player->rate),
      'minRate'       => new MinRate($user->player->min_rate),
      'maxRate'       => new MaxRate($user->player->max_rate),
      'win'           => new Win($user->player->win),
      'defeat'        => new Defeat($user->player->defeat),
      'games'         => new Games($user->player->games),
      'gamePackages'  => new GamePackages($user->player->game_packages),
      'joinedAt'      => new Datetime($user->player->joined_at),
      'lastGameAt'    => new Datetime($user->player->last_game_at),
      'enabled'       => new Enabled($user->player->enabled)
    ]);

    return new User([
      'id'            => new UserId($user->id),
      'player'        => $player,
      'playerId'      => new PlayerId($user->player_id),
      'role'          => $role,
      'roleId'        => new RoleId($user->role_id),
      'name'          =>  new Name($user->name),
      'steamId'       => new SteamId($user->steam_id),
      'twitterId'     => new TwitterId($user->twitter_id),
      'webSiteUrl'    => new WebSiteUrl($user->website_url),
      'avatorImage'   => new AvatorImage($user->avator_image),
      'email'         => new Email($user->email),
      'status'        => new Status($user->status),
    ]);
  }

  /**
   * @param User $user
   */
  public function register(User $user): void
  {
    EloquentUser::create([
      'player_id'   => $user->getPlayerId()->getValue(),
      'role_id'     => $user->getRoleId()->getValue(),
      'name'        => $user->getName()->getValue(),
      'email'       => $user->getEmail()->getValidEmail(),
      'password'    => $user->getPassword()->getEncrypted(),
    ]);
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
}
