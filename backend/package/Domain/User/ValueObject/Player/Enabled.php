<?php declare(strict_types=1);

namespace Package\Domain\User\ValueObject\Player;

class Enabled {
  private $value;

  public function __construct($value)
  {
    $this->value = (bool) $value;
  }

  public function getValue(): bool
  {
    return $this->value;
  }
}