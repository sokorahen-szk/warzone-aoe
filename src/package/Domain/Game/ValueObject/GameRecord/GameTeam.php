<?php declare(strict_types=1);

namespace Package\Domain\Game\ValueObject\GameRecord;

class GameTeam {
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