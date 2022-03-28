<?php declare(strict_types=1);

namespace Package\Domain\User\ValueObject;

class AvatorImage {
  private $value;

  public function __construct($value)
  {
    $this->value = $value;
  }

  public function getValue(): ?string
  {
    if (!$this->value) {
      return null;
    }

    return $this->value;
  }

  public function getImageFullPath(): ?string
  {
    $v = $this->getValue();
    if ($v) {
      return url($this->getValue());
    }

    return null;
  }
}