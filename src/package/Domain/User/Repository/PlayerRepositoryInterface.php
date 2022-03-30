<?php declare(strict_types=1);

namespace Package\Domain\User\Repository;

use Package\Domain\System\Entity\Paginator;
use Package\Domain\User\Entity\Player;
use Package\Domain\User\ValueObject\Player\GamePackages;
use Package\Domain\User\ValueObject\Player\PlayerId;

interface PlayerRepositoryInterface {
  /**
   * プレイヤー 一覧取得
   * @param Paginator|null $paginator
   * @return Player[]
   */
  public function list(?Paginator $paginator = null): array;

  /**
   * プレイヤー 総件数
   * @return int
   */
  public function listCount(): int;

  /**
   * プレイヤー新規作成
   * @param Player $player
   * @return PlayerId|null
   */
  public function register(Player $player): ?PlayerId;

  /**
   * プレイヤー情報取得
   * @param PlayerId $playerId
   * @return Player
   */
  public function getById(PlayerId $playerId): Player;

  /**
   * プレイヤーの有効性　更新
   * @param Player $player
   */
  public function updateEnabled(Player $player): void;

  /**
   * プレイヤーのゲームパッケージ修正
   *
   * @param PlayerId $playerId
   * @param GamePackages $gamePackages
   * @return void
   */
  public function updateGamePackage(PlayerId $playerId, GamePackages $gamePackages): void;

  /**
   * プレイヤー 更新
   *
   * @param Player $player
   * @return void
   */
  public function update(Player $player): void;
}