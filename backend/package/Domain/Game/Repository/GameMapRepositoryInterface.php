<?php declare(strict_types=1);

namespace Package\Domain\Game\Repository;

use Package\Domain\Game\Entity\GameMap;
use Package\Domain\Game\ValueObject\GameMap\GameMapId;

interface GameMapRepositoryInterface {
  /**
   * ゲームマップ一覧を取得する
   * @return GameMap[]
   */
  public function list(): array;

  /**
   * 特定のゲームマップを取得する
   *
   * @param GameMapId $gameMapId
   * @return GameMap
   */
  public function get(GameMapId $gameMapId): GameMap;
}