<?php declare(strict_types=1);

namespace Package\Infrastructure\Eloquent\Game;

use Package\Domain\Game\Repository\GameRuleRepositoryInterface;
use App\Models\RuleModel as EloquentGameRule;
use Package\Domain\Game\Entity\GameRule;
use Package\Domain\Game\ValueObject\GameRule\GameRuleId;
use Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Package\Infrastructure\Eloquent\Converter;

class GameRuleRepository implements GameRuleRepositoryInterface
{
  /**
   * ゲームルール一覧を取得
   * @return GameRule[]
   */
  public function list(): array
  {
    $gameRules = EloquentGameRule::get();

    return Converter::gameRules($gameRules);
  }

  /**
   * 特定のゲームルールを取得する
   *
   * @param GameRuleId $gameRuleId
   * @return GameRule
   */
  public function get(GameRuleId $gameRuleId): GameRule
  {
    try {
      $gameRule = EloquentGameRule::findOrFail($gameRuleId->getValue());
      $resource = Converter::gameRule($gameRule);
    } catch (ModelNotFoundException $e) {
      Log::Info($e->getMessage());
      throw new ModelNotFoundException(sprintf("ゲームルールID %d の情報が存在しません。", $gameRuleId->getValue()));
    }

    return $resource;
  }
}