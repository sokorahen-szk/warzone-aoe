<?php declare(strict_types=1);

namespace Package\Domain\User\ValueObject;

class AvatorImage {
  private $value;

  const DEFAULT_IMAGE_PATH = '/storage/profile/0.png';

  public function __construct($value)
  {
    $this->value = $value;
  }

  public function getValue(): string
  {
    return $this->value;
  }

  public function getImageFullPath()
  {
    if (!$this->value) {
      return url(self::DEFAULT_IMAGE_PATH);
    }

    return url($this->value);
  }
}