<?php declare(strict_types=1);

namespace Package\Domain\User\ValueObject\Register;

class RegisterStatus {
  private $value;

  const REGISTER_REQUEST_STATUS_WAITING = 1;
  const REGISTER_REQUEST_STATUS_APPROVE = 2;
  const REGISTER_REQUEST_STATUS_REJECT = 3;

  private $enums = [
    self::REGISTER_REQUEST_STATUS_WAITING       => 'waiting',
    self::REGISTER_REQUEST_STATUS_APPROVE       => 'approve',
    self::REGISTER_REQUEST_STATUS_REJECT        => 'reject',
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

  public function isValid(): bool
  {
    return $this->value === self::REGISTER_REQUEST_STATUS_APPROVE;
  }
}
