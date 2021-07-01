<?php declare(strict_types=1);

namespace Package\Domain\System\ValueObject;

class Page {
  private $value;

  public function __construct($value = 0)
  {
    $this->value = $value;
  }

  public function getValue(): ?int
  {
    return $this->value;
  }
}