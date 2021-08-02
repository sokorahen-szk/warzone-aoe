<?php declare(strict_types=1);

namespace Package\Infrastructure\Eloquent\Game;

use Package\Domain\Game\Repository\GameRuleRepositoryInterface;
use App\Models\RuleModel as EloquentGameRule;
use Package\Domain\Game\ValueObject\GamePackage\GamePackageId;
use Package\Domain\System\ValueObject\Name;
use Package\Domain\System\ValueObject\Description;
use Package\Domain\Game\Entity\GameRule;
use Package\Domain\Game\ValueObject\GameRule\GameRuleId;
use Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GameRuleRepository implements GameRuleRepositoryInterface {
  /**
   * ゲームルールを取得する
   *
   * @param GameRuleId $gameRuleId
   * @return GameRule
   */
  public function get(GameRuleId $gameRuleId): GameRule
  {
    try {
      $gameRule = EloquentGameRule::findOrFail($gameRuleId->getValue());
      $resource = $this->toGameRule($gameRule);
    } catch (ModelNotFoundException $e) {
      Log::Info($e->getMessage());
      throw new ModelNotFoundException(sprintf("ゲームルールID %d の情報が存在しません。", $gameRuleId->getValue()));
    }

    return $resource;
  }

  private function toGameRule(EloquentGameRule $gameRule): GameRule
  {
    return new GameRule([
      'gameRuleId'       => new GameRuleId($gameRule->id),
      'gamePackageId'    => new GamePackageId($gameRule->game_package_id),
      'name'             => new Name($gameRule->name),
      'description'      => new Description($gameRule->description),
    ]);
  }
}