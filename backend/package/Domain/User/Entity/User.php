<?php

namespace Package\Domain\User\Entity;

// ValueObjects
use Package\Domain\User\ValueObject\UserId;
use Package\Domain\User\ValueObject\PlayerId;
use Package\Domain\User\ValueObject\RoleId;
use Package\Domain\User\ValueObject\Name;
use Package\Domain\User\ValueObject\TwitterId;
use Package\Domain\User\ValueObject\WebSiteUrl;
use Package\Domain\User\ValueObject\AvatorImage;
use Package\Domain\User\ValueObject\Email;
use Package\Domain\User\ValueObject\Password;

// Entities
use Package\Domain\User\Entity\Role;

class User {
  private $id;
  private $playerId;
  private $role;
  private $name;
  private $twitterId;
  private $webSiteUrl;
  private $avatorImage;
  private $email;
  private $password;

  public function __construct(
    ?UserId $id,
    PlayerId $playerId,
    Role $role,
    Name $name,
    TwitterId $twitterId,
    WebSiteUrl $webSiteUrl,
    AvatorImage $avatorImage,
    Email $email,
    ?Password $password
  )
  {
    $this->id = $id;
    $this->playerId = $playerId;
    $this->role = $role;
    $this->name = $name;
    $this->twitterId = $twitterId;
    $this->webSiteUrl = $webSiteUrl;
    $this->avatorImage = $avatorImage;
    $this->email = $email;
    $this->password = $password;
  }

  /**
   * @return UserId|null
   */
  public function getId(): ?UserId
  {
    return $this->id;
  }

  /**
   * @return PlayerId
   */
  public function getPlayerId(): PlayerId
  {
    return $this->playerId;
  }

  /**
   * @return Role
   */
  public function getRole(): Role
  {
    return $this->role;
  }

  /**
   * @return Name
   */
  public function getName(): Name
  {
    return $this->name;
  }

  /**
   * @return TwitterId
   */
  public function getTwitterId(): TwitterId
  {
    return $this->twitterId;
  }

  /**
   * @return WebSiteURL
   */
  public function getWebSiteUrl(): WebSiteUrl
  {
    return $this->webSiteUrl;
  }

  /**
   * @return AvatorImage
   */
  public function getAvatorImage(): AvatorImage
  {
    return $this->avatorImage;
  }

  /**
   * @return Email
   */
  public function getEmail(): Email
  {
    return $this->email;
  }

  /**
   * @return Password|null
   */
  public function getPassword(): ?Password
  {
    return $this->password;
  }

}