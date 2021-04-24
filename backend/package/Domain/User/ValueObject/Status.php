<?php declare(strict_types=1);

namespace Package\Domain\User\ValueObject;

class Status {
  private $value;

  private $enums = [
    0 => 'waiting',
    1 => 'active',
    2 => 'withdrawal',
    3 => 'banned',
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
}