<?php declare(strict_types=1);

namespace Package\Infrastructure\Eloquent\Player;

use Package\Domain\User\Repository\PlayerRepositoryInterface;
use Package\Domain\User\ValueObject\Player\PlayerId;
use Package\Domain\User\ValueObject\Player\PlayerName;
use Package\Domain\User\ValueObject\Player\Mu;
use Package\Domain\User\ValueObject\Player\Sigma;
use Package\Domain\User\ValueObject\Player\Rate;
use Package\Domain\User\ValueObject\Player\MinRate;
use Package\Domain\User\ValueObject\Player\MaxRate;
use Package\Domain\User\ValueObject\Player\Win;
use Package\Domain\User\ValueObject\Player\Defeat;
use Package\Domain\User\ValueObject\Player\Games;
use Package\Domain\User\ValueObject\Player\GamePackages;
use Package\Domain\User\ValueObject\Player\Datetime;
use Package\Domain\User\ValueObject\Player\Enabled;
use Package\Domain\User\Entity\Player;
use App\Models\PlayerModel as EloquentPlayer;

class PlayerRepository implements PlayerRepositoryInterface {
  /**
   * @return array|null
   */
  public function list(): ?array
  {
    $players = EloquentPlayer::get();

    if (!$players) {
      return null;
    }

    $results = [];

    foreach ($players as $player) {
      $results[] = new Player([
        'playerId'      => new PlayerId($player->id),
        'playerName'    => new PlayerName($player->name),
        'mu'            => new Mu($player->mu),
        'sigma'         => new Sigma($player->sigma),
        'rate'          => new Rate($player->rate),
        'minRate'       => new MinRate($player->min_rate),
        'maxRate'       => new MaxRate($player->max_rate),
        'win'           => new Win($player->win),
        'defeat'        => new Defeat($player->defeat),
        'games'         => new Games($player->games),
        'gamePackages'  => new GamePackages($player->game_packages),
        'joinedAt'      => new Datetime($player->joined_at),
        'lastGameAt'    => new Datetime($player->last_game_at),
        'enabled'       => new Enabled($player->enabled),
      ]);
    }
    return $results;
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
    $player = EloquentPlayer::first($playerId);

    if (!$player) {
      throw new \Exception("プレイヤー情報が取得できませんでした。");
    }

    return new Player([
      'playerId'      => new PlayerId($player->id),
      'playerName'    => new PlayerName($player->name),
      'mu'            => new Mu($player->mu),
      'sigma'         => new Sigma($player->sigma),
      'rate'          => new Rate($player->rate),
      'minRate'       => new MinRate($player->min_rate),
      'maxRate'       => new MaxRate($player->max_rate),
      'win'           => new Win($player->win),
      'defeat'        => new Defeat($player->defeat),
      'games'         => new Games($player->games),
      'gamePackages'  => new GamePackages($player->game_packages),
      'joinedAt'      => new Datetime($player->joined_at),
      'lastGameAt'    => new Datetime($player->last_game_at),
      'enabled'       => new Enabled($player->enabled),
    ]);
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