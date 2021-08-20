<?php

namespace Package\Domain\User\Entity;

use Package\Domain\Resource;

// ValueObjects
use Package\Domain\User\ValueObject\UserId;
use Package\Domain\User\ValueObject\Role\RoleId;
use Package\Domain\User\ValueObject\Name;
use Package\Domain\User\ValueObject\SteamId;
use Package\Domain\User\ValueObject\TwitterId;
use Package\Domain\User\ValueObject\WebSiteUrl;
use Package\Domain\User\ValueObject\AvatorImage;
use Package\Domain\User\ValueObject\Email;
use Package\Domain\User\ValueObject\Status;
use Package\Domain\User\ValueObject\Password;
use Package\Domain\User\ValueObject\Player\GamePackageIds;
use Package\Domain\System\ValueObject\Datetime;

// Entities
use Package\Domain\User\Entity\Role;

class User extends Resource {
  protected $id;
  protected $roleId;
  protected $name;
  protected $steamId;
  protected $twitterId;
  protected $webSiteUrl;
  protected $avatorImage;
  protected $email;
  protected $status;
  protected $password;
  protected $gamePackageIds;
  protected $createdAt;

  protected $players;
  protected $role;

  public function __construct($data)
  {
    parent::__construct($data);
  }

  /**
   * @return UserId|null
   */
  public function getId(): ?UserId
  {
    return $this->id;
  }

  /**
   * @return RoleId|null
   */
  public function getRoleId(): ?RoleId
  {
    return $this->roleId;
  }

  /**
   * @return Name|null
   */
  public function getName(): ?Name
  {
    return $this->name;
  }

  /**
   * @param Name $name
   */
  public function changeName(Name $name): void
  {
    $this->name = $name;
  }

  /**
   * @return SteamId|null
   */
  public function getSteamId(): ?SteamId
  {
    return $this->steamId;
  }

  /**
   * @param SteamId $steamId
   */
  public function changeSteamId(SteamId $steamId): void
  {
    $this->steamId = $steamId;
  }

  /**
   * @return TwitterId|null
   */
  public function getTwitterId(): ?TwitterId
  {
    return $this->twitterId;
  }

  /**
   * @param TwitterId $twitterId
   */
  public function changeTwitterId(TwitterId $twitterId): void
  {
    $this->twitterId = $twitterId;
  }

  /**
   * @return WebSiteUrl|null
   */
  public function getWebSiteUrl(): ?WebSiteUrl
  {
    return $this->webSiteUrl;
  }

  /**
   * @param WebSiteUrl $webSiteUrl
   */
  public function changeWebSiteUrl(WebSiteUrl $webSiteUrl): void
  {
    $this->webSiteUrl = $webSiteUrl;
  }

  /**
   * @return AvatorImage|null
   */
  public function getAvatorImage(): ?AvatorImage
  {
    return $this->avatorImage;
  }

  /**
   * @return Email|null
   */
  public function getEmail(): ?Email
  {
    return $this->email;
  }

  /**
   * @param Email $email
   */
  public function changeEmail(Email $email): void
  {
    $this->email = $email;
  }

  /**
   * @return Status|null
   */
  public function getStatus(): ?Status
  {
    return $this->status;
  }

  /**
   * @return Password|null
   */
  public function getPassword(): ?Password
  {
    return $this->password;
  }

  /**
   * @param Password $password
   */
  public function changePassword(Password $password): void
  {
    $this->password = $password;
  }

  /**
   * @return GamePackageIds|null
   */
  public function getGamePackageIds(): ?GamePackageIds
  {
    return $this->gamePackageIds;
  }

  /**
   * @return Datetime|null
   */
  public function getCreatedAt(): ?Datetime
  {
    return $this->createdAt;
  }

  /**
   * @return Player[]
   */
  public function getPlayers(): array
  {
    return $this->players;
  }

  /**
   * @return Role
   */
  public function getRole(): Role
  {
    return $this->role;
  }
}