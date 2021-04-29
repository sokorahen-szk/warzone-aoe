<?php declare(strict_types=1);

namespace Package\Domain\User\Entity;

use Package\Domain\Resource;
use Package\Domain\User\ValueObject\Register\RegisterId;
use Package\Domain\User\ValueObject\Player\PlayerId;
use Package\Domain\User\ValueObject\UserId;
use Package\Domain\User\ValueObject\Register\RegisterStatus;
use Package\Domain\User\ValueObject\Register\Remarks;

class RegisterRequest extends Resource {

  protected $registerId;
  protected $playerId;
  protected $userId;
  protected $registerStatus;
  protected $remarks;

  public function __construct($data)
  {
    parent::__construct($data);
  }

  /**
   * @return RegisterId|null
   */
  public function getRegisterId(): ?RegisterId
  {
    return $this->registerId;
  }

  /**
   * @return PlayerId|null
   */
  public function getPlayerId(): ?PlayerId
  {
    return $this->playerId;
  }

  /**
   * @return UserId|null
   */
  public function getUserId(): ?UserId
  {
    return $this->userId;
  }

  /**
   * @return RegisterStatus|null
   */
  public function getRegisterStatus(): ?RegisterStatus
  {
    return $this->registerStatus;
  }

  /**
   * @return Remarks|null
   */
  public function getRemarks(): ?Remarks
  {
    return $this->remarks;
  }
}