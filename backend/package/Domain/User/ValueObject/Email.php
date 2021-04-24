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

    if(!preg_match("/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/", $value)) {
      throw new UserArgumentException(sprintf("%sの形式でありません。", self::LABEL));
    }

    $this->value = $value;
  }

  public function getValue(): string
  {
    return $this->value;
  }

  public function getValidEmail(): ?string
  {
    if ($this->value == "sample@example.com") return null;
    return $this->getValue();
  }
}