<?php declare(strict_types=1);

namespace Package\Infrastructure\Eloquent\Game;

use Package\Domain\Game\Repository\GameRecordRepositoryInterface;
use Package\Domain\User\Entity\User;
use Package\Domain\System\ValueObject\Date;
use App\Models\GameRecordModel as EloquentGameRecordModel;

class GameRecordRepository implements GameRecordRepositoryInterface
{
    /**
    * 対戦履歴を日付範囲で取得する
    * @return array|null
    */
    public function listByDateRange(User $user, Date $beginDate, ?Date $endDate): ?array
    {
        $gameRecords = EloquentGameRecordModel::leftJoinPlayerMemories()
            ->select([
                "game_records.id AS game_record_id",
                "game_records.game_package_id",
                "game_records.winning_team",
                "game_records.status",
                "game_records.started_at",
                "game_records.finished_at",
                "player_memories.id AS player_memory_id",
                "player_memories.player_id AS player_id",
                "player_memories.team",
                "player_memories.mu",
                "player_memories.sigma",
                "player_memories.rate",
            ])
            ->whereStartedAtByDateRange($beginDate, $endDate)
            ->whereStatusByFinished()
            ->whereByPlayerId($user->getPlayerId())
            ->with('game_package')
            ->get();

        return $gameRecords->toArray();
    }
}
