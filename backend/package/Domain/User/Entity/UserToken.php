<?php

namespace Package\Domain\User\Entity;

use Package\Domain\Resource;
use Package\Domain\System\ValueObject\Datetime;
use Package\Domain\System\ValueObject\Token;
use Package\Domain\User\ValueObject\Email;
use Package\Domain\User\ValueObject\UserId;
use Package\Domain\User\ValueObject\UserToken\UserTokenId;

class UserToken extends Resource {
  protected $userTokenId;
  protected $userId;
  protected $email;
  protected $token;
  protected $expireAt;
  protected $createdAt;
  protected $updatedAt;

  public function __construct($data) {
    parent::__construct($data);
  }

  /**
   * @return UserTokenId
   */
  public function getUserTokenId(): UserTokenId
  {
    return $this->userTokenId;
  }

  /**
   * @return UserId
   */
  public function getUserId(): UserId
  {
    return $this->userId;
  }

  /**
   * @return Email
   */
  public function getEmail(): Email
  {
    return $this->email;
  }

  /**
   * @return Token
   */
  public function getToken(): Token
  {
    return $this->token;
  }

  /**
   * @return Datetime
   */
  public function getExpireAt(): Datetime
  {
    return $this->expireAt;
  }

  /**
   * @return Datetime
   */
  public function getCreatedAt(): Datetime
  {
    return $this->createdAt;
  }

  /**
   * @return Datetime
   */
  public function getUpdatedAt(): Datetime
  {
    return $this->updatedAt;
  }
}
