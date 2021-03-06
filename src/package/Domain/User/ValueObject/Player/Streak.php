<?php declare(strict_types=1);

namespace Package\Domain\User\ValueObject\Player;

class Streak {
  private $value;

  public function __construct($value)
  {
    $this->value = (int) $value;
  }

  public function getValue(): int
  {
    return $this->value;
  }

  public function increment(): void
  {
    $this->value++;
  }

  public function decrement(): void
  {
    $this->value--;
  }

  public function clear(): void
  {
    $this->value = 0;
  }
}