<?php

namespace Package\Domain\User\Entity;

use Package\Domain\Resource;

// ValueObjects
use Package\Domain\User\ValueObject\UserId;
use Package\Domain\User\ValueObject\Player\PlayerId;
use Package\Domain\User\ValueObject\Role\RoleId;
use Package\Domain\User\ValueObject\Name;
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
   * @return Name|null
   */
  public function getName(): ?Name
  {
    return $this->name;
  }

  /**
   * @return TwitterId|null
   */
  public function getTwitterId(): ?TwitterId
  {
    return $this->twitterId;
  }

  /**
   * @return WebSiteURL|null
   */
  public function getWebSiteUrl(): ?WebSiteUrl
  {
    return $this->webSiteUrl;
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

}