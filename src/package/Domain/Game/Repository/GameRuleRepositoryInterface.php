<?php declare(strict_types=1);

namespace Package\Domain\Game\Repository;

use Package\Domain\Game\ValueObject\GameRule\GameRuleId;
use Package\Domain\Game\Entity\GameRule;

interface GameRuleRepositoryInterface
{
  /**
   * ゲームルールを取得する
   *
   * @param GameRuleId $gameRuleId
   * @return GameRule
   */
  public function get(GameRuleId $gameRuleId): GameRule;
}