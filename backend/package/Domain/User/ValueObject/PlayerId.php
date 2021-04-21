<?php declare(strict_types=1);

namespace Package\Domain\User\ValueObject;

use Package\Domain\User\Exceptions\UserArgumentNullException;
use Package\Domain\User\Exceptions\UserArgumentException;

class PlayerId {
  private $value;

  const LABEL = 'プレイヤーID';

  public function __construct($value)
  {
    if (!$value) {
      throw new UserArgumentNullException(sprintf("%sが設定されていません。", self::LABEL));
    }

    if ((int) $value < 1 || (int) $value >= 1000000) {
      throw new UserArgumentException(sprintf("%sの値の範囲を満たしていません。", self::LABEL));
    }

    $this->value = (int) $value;
  }

  public function getValue(): int
  {
    return $this->value;
  }
}