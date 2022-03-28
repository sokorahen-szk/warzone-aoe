<?php declare(strict_types=1);

namespace Package\Domain\User\ValueObject;

class SteamId {
  private $value;

  const BASE_STEAM_URL = "https://steamcommunity.com/profiles";

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
    return sprintf("%s/%s", self::BASE_STEAM_URL, $this->value);
  }
}