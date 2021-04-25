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
      $results[] = new Player(
        new PlayerId($player->id),
        new PlayerName($player->name),
        new Mu($player->mu),
        new Sigma($player->sigma),
        new Rate($player->rate),
        new MinRate($player->min_rate),
        new MaxRate($player->max_rate),
        new Win($player->win),
        new Defeat($player->defeat),
        new Games($player->games),
        new GamePackages($player->game_packages),
        new Datetime($player->joined_at),
        new Datetime($player->last_game_at),
        new Enabled($player->enabled)
      );
    }
    return $results;
  }
}