<?php declare(strict_types=1);

namespace Package\Domain\Game\ValueObject\GameRecordToken;

class GameToken {
  private $value;

  public function __construct($value)
  {
    $this->value = $value;
  }

  public function getValue(): ?int
  {
    return $this->value;
  }
}