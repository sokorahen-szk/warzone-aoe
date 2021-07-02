<?php declare(strict_types=1);

namespace Package\Domain\Game\ValueObject\GameRule;

class VictoryPrediction {
  private $value;

  public function __construct($value)
  {
    $this->value = (int) $value;
  }

  public function getValue(): ?int
  {
    return $this->value;
  }
}
