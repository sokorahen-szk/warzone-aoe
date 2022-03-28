<?php declare(strict_types=1);

namespace Package\Infrastructure\Eloquent\Player;

use Package\Domain\User\Repository\PlayerMemoryRepositoryInterface;

use Package\Domain\User\Entity\Player;
use Package\Domain\Game\ValueObject\GameRecord\GameRecordId;
use Package\Domain\Game\ValueObject\GameRecord\GameTeam;

use App\Models\PlayerMemoryModel as EloquentPlayerMemory;

class PlayerMemoryRepository implements PlayerMemoryRepositoryInterface {
    /**
     * 個別記録作成（試合開始）
     *
     * @param GameRecordId $gameRecordId
     * @param Player $player
     * @param GameTeam $gameTeam
     * @return void
     */
    public function create(GameRecordId $gameRecordId, Player $player, GameTeam $gameTeam): void
    {
        EloquentPlayerMemory::create([
            'player_id' => $player->getPlayerId()->getValue(),
            'game_record_id' => $gameRecordId->getValue(),
            'team' => $gameTeam->getValue(),
            'mu' => $player->getMu()->getValue(),
            'sigma' => $player->getSigma()->getValue(),
            'rate' => $player->getRate()->getValue(),
        ]);
    }

    /**
     * 個別記録更新（試合終了）
     *
     * @param GameRecordId $gameRecordId
     * @param Player $player
     * @return void
     */
    public function update(GameRecordId $gameRecordId, Player $player): void
    {
        EloquentPlayerMemory::where('player_id', $player->getPlayerId()->getValue())
            ->where('game_record_id', $gameRecordId->getValue())
            ->update([
                'after_mu' => $player->getMu()->getValue(),
                'after_sigma' => $player->getSigma()->getValue(),
                'after_rate' => $player->getRate()->getValue(),
            ]);
    }
}