<?php declare(strict_types=1);

namespace Package\Domain\User\ValueObject\Player;

use Carbon\Carbon;

class Datetime {
  private $value;

  public function __construct($value)
  {
    $this->value = Carbon::parse($value);
  }

  public function getValue(): Carbon
  {
    return $this->value;
  }
}