<?php

namespace Package\Usecase\User\GetInfo;

use Package\Domain\User\Entity\User;

/**
 * Data Transfer Object
 */

class UserData {
  public $id;
  public $playerId;
  public $roleId;
  public $name;
  public $twitterId;
  public $avatorImage;
  public $email;

  public function __construct(User $source)
  {
    $this->id = $source->getId()->getValue();
    $this->playerId = $source->getPlayerId()->getValue();
    $this->roleId = $source->getRoleId()->getValue();
    $this->name = $source->getName()->getValue();
    $this->twitterId = $source->getTwitterId()->getValue();
    $this->avatorImage = $source->getAvatorImage()->getValue();
    $this->email = $source->getEmail()->getValue();
  }
}