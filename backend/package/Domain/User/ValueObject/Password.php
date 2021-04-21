<?php declare(strict_types=1);

namespace Package\Domain\User\ValueObject;

use Package\Domain\User\Exceptions\UserArgumentNullException;

class Password {
  private $value;

  const LABEL = 'パスワード';

  public function __construct($value)
  {
    if (!$value) {
      throw new UserArgumentNullException(sprintf("%sが設定されていません。", self::LABEL));
    }

    $this->value = $value;
  }

  public function getEncrypted(): string
  {
    return bcrypt($this->value);
  }

  public function getPlain(): string
  {
    return $this->value;
  }
}