<?php declare(strict_types=1);

namespace Package\Domain\User\ValueObject\Role;

class RoleId {
  private $value;

  public function __construct($value)
  {
    $this->value = (int) $value;
  }

  public function getValue(): int
  {
    return $this->value;
  }
}