<?php declare(strict_types=1);

namespace Package\Domain\User\ValueObject;

class WebSiteUrl {
  private $value;

  public function __construct($value)
  {
    $this->value = $value;
  }

  public function getValue(): ?string
  {
    return $this->value;
  }
}