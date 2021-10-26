<?php declare(strict_types=1);

namespace Package\Infrastructure\Eloquent\Player;

use Package\Domain\User\Repository\PlayerRepositoryInterface;
use Package\Domain\User\ValueObject\Player\PlayerId;
use Package\Domain\User\Entity\Player;
use App\Models\PlayerModel as EloquentPlayer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Log;

use Package\Infrastructure\Eloquent\Converter;

class PlayerRepository implements PlayerRepositoryInterface {
  /**
   * @return Player[]
   */
  public function list(): array
  {
    $players = EloquentPlayer::with('user')
      ->enabled()
      ->get();

    if (!$players) {
      return [];
    }

    return Converter::players($players);
  }

  /**
   * プレイヤー新規作成
   * @param Player $player
   * @return PlayerId|null
   * @
   */
  public function register(Player $player): ?PlayerId
  {
    $player = EloquentPlayer::create([
      'name'            => $player->getPlayerName()->getValue(),
      'game_packages'   => $player->getGamePackages()->getValue(),
    ]);

    return new PlayerId($player->id);
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
   * @param Player $player
   */
  public function updateEnabled(Player $player): void
  {
    if(!EloquentPlayer::find($player->getPlayerId()->getValue())
    ->update([
      'enabled'       => $player->getEnabled()->getValue(),
    ])) {
      throw new \Exception("更新に失敗しました。");
    }
  }
}