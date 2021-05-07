<?php declare(strict_types=1);

namespace Package\Domain\Game\ValueObject\GameMap;

class Image {
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