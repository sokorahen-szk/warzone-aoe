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
use Package\Domain\User\ValueObject\Status;
use Package\Domain\User\ValueObject\Password;

// Entities
use Package\Domain\User\Entity\Role;
use Package\Domain\User\Entity\Player;

class User {
  private $id;
  private $player;
  private $role;
  private $name;
  private $twitterId;
  private $webSiteUrl;
  private $avatorImage;
  private $email;
  private $status;
  private $password;

  public function __construct(
    ?UserId $id,
    Player $player,
    Role $role,
    Name $name,
    TwitterId $twitterId,
    WebSiteUrl $webSiteUrl,
    AvatorImage $avatorImage,
    Email $email,
    Status $status,
    ?Password $password
  )
  {
    $this->id = $id;
    $this->player = $player;
    $this->role = $role;
    $this->name = $name;
    $this->twitterId = $twitterId;
    $this->webSiteUrl = $webSiteUrl;
    $this->avatorImage = $avatorImage;
    $this->email = $email;
    $this->status = $status;
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
   * @return Player
   */
  public function getPlayer(): Player
  {
    return $this->player;
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
   * @return Status
   */
  public function getStatus(): Status
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