<?php declare(strict_types=1);

namespace Package\Infrastructure\Eloquent\Player;

use Package\Domain\User\Repository\PlayerRepositoryInterface;
use Package\Domain\User\ValueObject\Player\PlayerId;
use Package\Domain\User\ValueObject\UserId;
use Package\Domain\Game\ValueObject\GamePackage\GamePackageId;
use Package\Domain\User\Entity\Player;
use App\Models\PlayerModel as EloquentPlayer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Log;

use Package\Infrastructure\Eloquent\Converter;

class PlayerRepository implements PlayerRepositoryInterface {
  /**
   * @return Player[]|null
   */
  public function list(GamePackageId $gamePackageId): ?array
  {
    $players = EloquentPlayer::where('game_package_id', $gamePackageId->getValue())
      ->with('user')
      ->get();

    if (!$players) {
      return null;
    }

    return Converter::players($players);
  }

  /**
   * プレイヤー新規作成
   * @param Player $player
   * @
   */
  public function register(Player $player): void
  {
    EloquentPlayer::create([
      'user_id'            => $player->getUserId()->getValue(),
      'game_package_id'   => $player->getGamePackageId()->getValue(),
      'name'              => $player->getPlayerName()->getValue(),
    ]);
  }

  /**
   * プレイヤー情報取得
   * @param PlayerId $playerId
   * @return Player
   */
  public function getById(PlayerId $playerId): Player
  {
    try {
      $player = EloquentPlayer::findOrFail($playerId->getValue());
    } catch (ModelNotFoundException $e) {
      Log::Info($e->getMessage());
      throw new ModelNotFoundException(sprintf("プレイヤーID %d の情報が存在しません。", $playerId->getValue()));
    }

    return Converter::player($player);
  }

  /**
   * プレイヤーの有効性　更新
   * @param UserId $userId
   */
  public function updateEnabled(UserId $userId): void
  {
    if(!EloquentPlayer::where('user_id', $userId->getValue())
    ->update([
      'enabled' => true,
    ])) {
      throw new \Exception("更新に失敗しました。");
    }
  }
}