<?php declare(strict_types=1);

namespace Package\Domain\Register\ValueObject;

class Remarks {
  private $value;

  public function __construct($value)
  {
    $this->value = $value;
  }

  public function getValue(): int
  {
    return $this->value;
  }

}