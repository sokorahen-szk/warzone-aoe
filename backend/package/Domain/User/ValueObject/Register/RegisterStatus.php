<?php declare(strict_types=1);

namespace Package\Domain\User\ValueObject\Register;

class RegisterStatus {
  private $value;

  const USER_STATUS_WAITING = 1;
  const USER_STATUS_ACTIVE = 2;
  const USER_STATUS_WITHDRAWAL = 3;
  const USER_STATUS_BANNED = 4;

  private $enums = [
    self::USER_STATUS_WAITING     => 'waiting',
    self::USER_STATUS_ACTIVE      => 'active',
    self::USER_STATUS_WITHDRAWAL  => 'withdrawal',
    self::USER_STATUS_BANNED      => 'banned',
  ];

  public function __construct($value)
  {
    $this->value = (int) $value;
  }

  public function getValue(): int
  {
    return $this->value;
  }

  public function getEnumName(): ?string
  {
    if (!array_key_exists($this->value, $this->enums)) return null;
    return $this->enums[$this->value];
  }

  public function changeWaiting()
  {
    $this->value = self::USER_STATUS_WAITING;
  }

  public function changeActive()
  {
    $this->value = self::USER_STATUS_ACTIVE;
  }

  public function changeWithdrawal()
  {
    $this->value = self::USER_STATUS_WITHDRAWAL;
  }

  public function changeBanned()
  {
    $this->value = self::USER_STATUS_BANNED;
  }
}
