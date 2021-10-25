<?php declare(strict_types=1);

namespace Package\Domain\Game\ValueObject\GameRecord;

class VictoryPrediction {
  private $value;

  public function __construct($value)
  {
    $this->value = (float) $value;
  }

  public function getValue(): float
  {
    return $this->value;
  }

  public function getPerInt(): int
  {
    if ($this->value === 0) {
      return 0;
    }

    return (int) ceil($this->value * 100);
  }
}
