<?php declare(strict_types=1);

namespace Package\Domain\Game\Repository;

use Package\Domain\Game\ValueObject\GameRule\GameRuleId;
use Package\Domain\Game\Entity\GameRule;

interface GameRuleRepositoryInterface
{
  /**
   * ゲームルール一覧を取得する
   * @return GameRule[]
   */
  public function list(): array;

  /**
   * 特定のゲームルールを取得する
   *
   * @param GameRuleId $gameRuleId
   * @return GameRule
   */
  public function get(GameRuleId $gameRuleId): GameRule;
}