<?php declare(strict_types=1);

namespace Package\Domain\System\ValueObject;

class Token {
  private $value;

  public function __construct($value)
  {
    $this->value = $value;
  }

  public function getValue(): string
  {
    return $this->value;
  }

  public function getEncrypted()
  {
    return $this->generate($this->value);
  }

  private function generate($plainText)
  {
    return hash('sha256', $plainText);
  }
}