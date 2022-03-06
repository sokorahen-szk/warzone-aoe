<?php declare(strict_types=1);

namespace Package\Infrastructure\Eloquent\User;

use Package\Domain\User\Repository\UserRepositoryInterface;
use Package\Domain\User\ValueObject\UserId;
use Package\Domain\User\ValueObject\Name;
use Package\Domain\User\Entity\User;
use Package\Domain\User\Entity\UserAvator;

use App\Models\UserModel as EloquentUser;
use Package\Infrastructure\Eloquent\Converter;
use Package\Domain\System\Entity\Paginator;
use Package\Domain\User\ValueObject\Email;
use Package\Domain\User\ValueObject\Role\RoleId;
use Package\Domain\User\ValueObject\Status as UserStatus;

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

    $player =  Converter::player($user->player);
    $role =  Converter::role($user->role);

    return Converter::user($user, $player, $role);
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

    $player =  Converter::player($user->player);
    $role =  Converter::role($user->role);

    return Converter::user($user, $player, $role);
  }

  /**
   * @param Email $email
   * @return User|null
   */
  public function findByEmail(Email $email): ?User
  {
    $user = EloquentUser::where('email', $email->getValue())
    ->with(['player', 'role'])
    ->first();

    if (!$user) {
      return null;
    }

    $player =  Converter::player($user->player);
    $role =  Converter::role($user->role);

    return Converter::user($user, $player, $role);
  }

  /**
   * @param User $user
   * @return UserId
   */
  public function register(User $user): UserId
  {
    $user = EloquentUser::create([
      'player_id'   => $user->getPlayerId()->getValue(),
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
   * @param UserId $userId
   * @param UserStatus $userStatus
   */
  public function changeStatus(UserId $userId, UserStatus $userStatus): void
  {
    EloquentUser::findOrFail($userId->getValue())
    ->update([
      'status'  => $userStatus->getValue(),
    ]);
  }

  /**
   * @param UserId $userId
   * @param RoleId $roleId
   */
  public function changeRoleId(UserId $userId, RoleId $roleId): void
  {
    EloquentUser::findOrFail($userId->getValue())
    ->update([
      'role_id'  => $roleId->getValue(),
    ]);
  }

  /**
   * @param Paginator $paginator
   * @return User[]
   */
  public function list(Paginator $paginator): array
  {
    $users = EloquentUser::offset($paginator->getNextOffset())
      ->limit($paginator->getLimit()->getValue())
      ->get();

    return Converter::users($users);
  }

  /**
   * @return int
   */
  public function listCount(): int
  {
    $count = EloquentUser::count();
    return $count;
  }
}
