<?php declare(strict_types=1);

namespace Package\Domain\System\ValueObject;

class Limit {
  private $value;

  const OFFSET_LIMIT_LENGTH = 10000;

  public function __construct($value = 0)
  {
    $v = (int) $value;
    if ($v > self::OFFSET_LIMIT_LENGTH) {
      // TODO: ここはException作って対応したい
      throw new \Exception(sprintf("Offsetの最大値を超えています。最大値:%d", self::OFFSET_LIMIT_LENGTH));
    }
    $this->value = $v;
  }

  public function getValue(): int
  {
    return $this->value;
  }
}