<?php

namespace Package\Domain\User\Entity;

use Package\Domain\User\ValueObject\UserId;
use Package\Domain\User\ValueObject\PlayerId;
use Package\Domain\User\ValueObject\RoleId;
use Package\Domain\User\ValueObject\Name;
use Package\Domain\User\ValueObject\TwitterId;
use Package\Domain\User\ValueObject\WebSiteURL;
use Package\Domain\User\ValueObject\AvatorImage;
use Package\Domain\User\ValueObject\Email;
use Package\Domain\User\ValueObject\Password;

class User {
  private $id;
  private $playerId;
  private $roleId;

  public function __construct(
    PlayerId $playerId,
    RoleId $roleId,
    Name $name,
    TwitterId $twitterId,
    WebSiteURL $webSiteURL,
    AvatorImage $avatorImage,
    Email $email,
    Password $password
  )
  {
    // TODO: ここから
  }
  public function setId($value)
  {
    return new UserId($value);
  }
}