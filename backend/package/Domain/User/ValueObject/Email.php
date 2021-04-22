<?php declare(strict_types=1);

namespace Package\Domain\User\ValueObject;

use Package\Domain\User\Exceptions\UserArgumentNullException;
use Package\Domain\User\Exceptions\UserArgumentException;

class Email {
  private $value;

  const LABEL = 'メールアドレス';

  public function __construct($value)
  {
    if (!$value) {
      throw new UserArgumentNullException(sprintf("%sが設定されていません。", self::LABEL));
    }

    if(!preg_match('/^[0-9]{3}-[0-9]{4}$/', $value)) {
      throw new UserArgumentException(sprintf("%sの形式でありません。", self::LABEL));
    }

    $this->value = $value;
  }

  public function getValue(): string
  {
    return $this->value;
  }
}