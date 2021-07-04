<?php declare(strict_types=1);

namespace Package\Domain\User\ValueObject\Player;

class Mu {
  private $value;

  public function __construct($value)
  {
    $this->value = (float) $value;
  }

  public function getValue(): float
  {
    return $this->value;
  }

  /**
   * ランクを表示
   * 「ランク」：μの値を1/100して、小数以下を四捨五入した値
   * @return int
   */
  public function getRank(): int
  {
    if ($this->value <= 0) return 0;
    return (int) round($this->value / 100);
  }
}