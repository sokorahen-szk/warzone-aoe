<?php declare(strict_types=1);

namespace Package\Domain\User\ValueObject;

class Status {
  private $value;

  private $enums = [
    1 => 'waiting',
    2 => 'active',
    3 => 'withdrawal',
    4 => 'banned',
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