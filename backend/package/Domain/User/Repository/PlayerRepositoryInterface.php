<?php declare(strict_types=1);

namespace Package\Domain\User\Repository;

use Package\Domain\User\Entity\Player;
use Package\Domain\User\ValueObject\UserId;
use Package\Domain\User\ValueObject\Player\PlayerId;
use Package\Domain\Game\ValueObject\GamePackage\GamePackageId;

interface PlayerRepositoryInterface {
  /**
   * @param GamePackageId $gamePackageId
   * @return array|null
   */
  public function list(GamePackageId $gamePackageId): ?array;

  /**
   * プレイヤー新規作成
   * @param Player $player
   * @
   */
  public function register(Player $player): void;

  /**
   * プレイヤー情報取得
   * @param PlayerId $playerId
   * @return Player
   */
  public function getById(PlayerId $playerId): Player;

  /**
   * プレイヤーの有効性　更新
   * @param UserId $userId
   */
  public function updateEnabled(UserId $userId): void;
}