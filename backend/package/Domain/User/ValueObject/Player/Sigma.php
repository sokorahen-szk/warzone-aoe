<?php declare(strict_types=1);

namespace Package\Domain\User\ValueObject\Player;

class Sigma {
  private $value;

  public function __construct($value)
  {
    $this->value = (float) $value;
  }

  public function getValue(): float
  {
    return $this->value;
  }
}