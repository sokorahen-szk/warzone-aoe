<?php declare(strict_types=1);

namespace Package\Domain\Game\ValueObject\GameRecord;

class GameRecordMuEnabled {
  private $value;

  const RAITING_MU_ENABLED = true;
  const RAITING_MU_DISABLED = false;

  public function __construct($value)
  {
    $this->value = (bool) $value;
  }

  public function getValue(): bool
  {
    return $this->value;
  }
}