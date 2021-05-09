<?php declare(strict_types=1);

namespace Package\Domain\Game\ValueObject;

class Name {
  private $value;

  public function __construct($value)
  {
    $this->value = $value;
  }

  public function getValue(): ?string
  {
    return $this->value;
  }
}