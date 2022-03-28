<?php declare(strict_types=1);

namespace Package\Domain\User\Repository;

use Package\Domain\User\Entity\Player;
use Package\Domain\Game\ValueObject\GameRecord\GameRecordId;
use Package\Domain\Game\ValueObject\GameRecord\GameTeam;

interface PlayerMemoryRepositoryInterface {
    /**
     * 個別記録作成
     *
     * @param GameRecordId $gameRecordId
     * @param Player $player
     * @param GameTeam $gameTeam
     * @return void
     */
    public function create(GameRecordId $gameRecordId, Player $player, GameTeam $gameTeam): void;

    /**
     * 個別記録更新（試合終了後）
     *
     * @param GameRecordId $gameRecordId
     * @param Player $player
     * @return void
     */
    public function update(GameRecordId $gameRecordId, Player $player): void;
}