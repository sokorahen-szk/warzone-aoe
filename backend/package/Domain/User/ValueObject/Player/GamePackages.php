<?php declare(strict_types=1);

namespace Package\Domain\User\ValueObject\Player;

class GamePackages {
  private $value;

  public function __construct($value)
  {
    $this->value = $value;
  }

  public function getValue(): ?string
  {
    return $this->value;
  }

  /**
   * 選択されている種別のリストを返す
   * @return array
   */
  public function getList(): array
  {
    if (!$this->value) return [];

    if (strpos($this->value, ',') === false) {
      return [$this->value];
    }

    $list = explode(',', $this->value);
    if (!$list) return [];

    return $list;
  }
}