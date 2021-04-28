<?php declare(strict_types=1);

namespace Package\Domain\User\Repository;

use Package\Domain\User\Entity\Player;
use Package\Domain\User\ValueObject\Player\PlayerId;

interface PlayerRepositoryInterface {
  /**
   * @return array|null
   */
  public function list(): ?array;

  /**
   * プレイヤー新規作成
   * @param Player $player
   * @return PlayerId|null
   * @
   */
  public function register(Player $player): ?PlayerId;
}