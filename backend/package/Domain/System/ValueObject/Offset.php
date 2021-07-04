<?php declare(strict_types=1);

namespace Package\Domain\System\ValueObject;

class Offset {
  private $value;

  public function __construct($value = 0)
  {
    if ($value <= 0) {
      // TODO: Exceptionの例外をカスタムExceptionに変更する
      throw new \Exception("1以上の数字を指定してください。");
    }

    $this->value = $value;
  }

  public function getValue(): int
  {
    return $this->value != 0 ? $this->value - 1 : 0;
  }
}