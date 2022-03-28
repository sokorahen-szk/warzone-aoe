<?php declare(strict_types=1);

namespace Package\Domain\User\ValueObject\Player;

class Rate {
  private $value;

  public function __construct($value)
  {
    $this->value = (int) $value;
  }

  public function getValue(): int
  {
    return $this->value;
  }

  /**
   * @param Rate $rate
   * @return int
   */
  public function diff(Rate $rate): int
  {
    return $this->value - $rate->getValue();
  }

  /**
   * @return string
   */
  public function getValueInSign(): string
  {
    if ($this->value < 0) {
      return sprintf('%d', $this->value);
    }

    return sprintf('+%d', $this->value);
  }
}