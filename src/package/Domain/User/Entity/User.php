<?php

namespace Package\Domain\User\Entity;

use Package\Domain\Resource;

// ValueObjects
use Package\Domain\User\ValueObject\UserId;
use Package\Domain\User\ValueObject\Player\PlayerId;
use Package\Domain\User\ValueObject\Role\RoleId;
use Package\Domain\User\ValueObject\Name;
use Package\Domain\User\ValueObject\SteamId;
use Package\Domain\User\ValueObject\TwitterId;
use Package\Domain\User\ValueObject\WebSiteUrl;
use Package\Domain\User\ValueObject\AvatorImage;
use Package\Domain\User\ValueObject\Email;
use Package\Domain\User\ValueObject\Status;
use Package\Domain\User\ValueObject\Password;

// Entities
use Package\Domain\User\Entity\Role;
use Package\Domain\User\Entity\Player;

class User extends Resource {
  protected $id;
  protected $player;
  protected $playerId;
  protected $role;
  protected $roleId;
  protected $name;
  protected $steamId;
  protected $twitterId;
  protected $webSiteUrl;
  protected $avatorImage;
  protected $email;
  protected $status;
  protected $password;

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
   * @return PlayerId|null
   */
  public function getPlayerId(): ?PlayerId
  {
    return $this->playerId;
  }

  /**
   * @return Player|null
   */
  public function getPlayer(): ?Player
  {
    return $this->player;
  }

  /**
   * @return Role|null
   */
  public function getRole(): ?Role
  {
    return $this->role;
  }

  /**
   * @return RoleId|null
   */
  public function getRoleId(): ?RoleId
  {
    return $this->roleId;
  }

  /**
   * @param RoleId $roleId
   */
  public function changeRoleId(RoleId $roleId): void
  {
    $this->roleId = $roleId;
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
   * @param Status $status
   */
  public function changeStatus(Status $status): void
  {
    $this->status = $status;
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

}