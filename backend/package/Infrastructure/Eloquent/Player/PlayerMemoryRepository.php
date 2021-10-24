<?php declare(strict_types=1);

namespace Package\Infrastructure\Eloquent\Player;

use Package\Domain\User\Repository\PlayerMemoryRepositoryInterface;

use Package\Domain\User\Entity\Player;
use Package\Domain\Game\ValueObject\GameRecord\GameRecordId;
use Package\Domain\Game\ValueObject\GameRecord\GameTeam;

use App\Models\PlayerMemoryModel as EloquentPlayerMemory;

class PlayerMemoryRepository implements PlayerMemoryRepositoryInterface {
    /**
     * 個別記録作成
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
}