<?php declare(strict_types=1);

namespace Package\Domain\User\ValueObject;

class TwitterId {
  private $value;

  const BASE_TWITTER_URL = "https://twitter.com";

  public function __construct($value)
  {
    $this->value = $value;
  }

  public function getValue(): ?string
  {
    return $this->value;
  }

  public function getFullUrl(): ?string
  {
    if (!$this->value) {
      return null;
    }
    return sprintf("%s/%s", self::BASE_TWITTER_URL, $this->value);
  }
}