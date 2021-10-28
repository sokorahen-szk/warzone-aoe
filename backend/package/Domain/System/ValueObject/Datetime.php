<?php declare(strict_types=1);

namespace Package\Domain\System\ValueObject;

use Carbon\Carbon;

class Datetime {
  /**
   * @var Carbon
   */
  private $value;

  public function __construct($value)
  {
    if ($value) {
      $this->value = Carbon::parse($value);
    } else {
      $this->value = null;
    }
  }

  public function getValue(): ?Carbon
  {
    return $this->value;
  }

  public function getDatetime(): ?string
  {
    return $this->value ? $this->value->format('Y-m-d H:i:s') : null;
  }

  public function getDate(): ?string
  {
    return $this->value ? $this->value->format('Y-m-d') : null;
  }

  public function addHours(int $hours): void
  {
    $this->value->addHours($hours);
  }
}