<?php declare(strict_types=1);

namespace Package\Domain\User\Entity;

use Package\Domain\Resource;
use Package\Domain\User\ValueObject\Register\RegisterId;
use Package\Domain\User\ValueObject\UserId;
use Package\Domain\User\ValueObject\Register\RegisterStatus;
use Package\Domain\User\ValueObject\Register\Remarks;
use Package\Domain\User\ValueObject\Register\CreatedByUserId;

use Package\Domain\User\Entity\User;

class RegisterRequest extends Resource {
  protected $registerId;
  protected $userId;
  protected $createdByUserId;
  protected $registerStatus;
  protected $remarks;

  protected $user;

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
   * @return UserId|null
   */
  public function getUserId(): ?UserId
  {
    return $this->userId;
  }

  /**
   * @return CreatedByUserId|null
   */
  public function getCreatedByUserId(): ?CreatedByUserId
  {
    return $this->createdByUserId;
  }

  /**
   * @return User
   */
  public function getUser(): User
  {
    return $this->user;
  }

  /**
   * @param UserId
   */
  public function changeUserId(UserId $userId): void
  {
    $this->userId = $userId;
  }

  /**
   * @return RegisterStatus|null
   */
  public function getRegisterStatus(): ?RegisterStatus
  {
    return $this->registerStatus;
  }

  /**
   * @param RegisterStatus
   */
  public function changeRegisterStatus(RegisterStatus $registerStatus): void
  {
    $this->registerStatus = $registerStatus;
  }

  /**
   * @return Remarks|null
   */
  public function getRemarks(): ?Remarks
  {
    return $this->remarks;
  }

  /**
   * @param Remarks
   */
  public function changeRemarks(Remarks $remarks): void
  {
    $this->remarks = $remarks;
  }

}