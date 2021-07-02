<?php declare(strict_types=1);

namespace Package\Infrastructure\Eloquent\Game;

use Package\Domain\Game\Repository\GameRecordRepositoryInterface;
use Package\Domain\System\ValueObject\Date;
use App\Models\GameRecordModel as EloquentGameRecordModel;

use Package\Domain\Game\ValueObject\GameRecord\GameRecordId;
use Package\Domain\Game\ValueObject\GamePackage\GamePackageId;
use Package\Domain\Game\ValueObject\GameRecord\GameStatus;
use Package\Domain\Game\ValueObject\GameRecord\GameTeam;
use Package\Domain\System\ValueObject\Datetime;
use Package\Domain\User\ValueObject\PlayerMemory\PlayerMemoryId;
use Package\Domain\User\ValueObject\Player\PlayerId;
use Package\Domain\User\ValueObject\Player\Mu;
use Package\Domain\User\ValueObject\Player\Sigma;
use Package\Domain\User\ValueObject\Player\Rate;

use Package\Domain\Game\Entity\GamePackage;
use Package\Domain\User\Entity\User;
use Package\Domain\User\Entity\PlayerMemory;
use Package\Domain\Game\Entity\GamePlayerRecord;

class GameRecordRepository implements GameRecordRepositoryInterface
{
    /**
    * 対戦履歴を日付範囲で取得する
    * @param User $user
    * @param Date $beginDate
    * @param Date|null $endDate
    * @return array
    */
    public function listByUserWithDateRange(User $user, Date $beginDate, ?Date $endDate): array
    {
        $gameRecords = EloquentGameRecordModel::leftJoinPlayerMemories()
            ->select([
                "game_records.id AS game_record_id",
                "game_records.game_package_id",
                "game_records.winning_team",
                "game_records.status",
                "game_records.started_at",
                "game_records.finished_at",
                "game_records.victory_prediction",
                "player_memories.id AS player_memory_id",
                "player_memories.player_id AS player_id",
                "player_memories.team",
                "player_memories.mu",
                "player_memories.after_mu",
                "player_memories.sigma",
                "player_memories.after_sigma",
                "player_memories.rate",
                "player_memories.after_rate",
            ])
            ->whereStartedAtByDateRange($beginDate, $endDate)
            ->whereStatusByFinished()
            ->whereByPlayerId($user->getPlayerId())
            ->with('game_package')
            ->get();

        if (!$gameRecords) {
            return [];
        }

        $results = [];

        foreach ($gameRecords as $gameRecord) {
            $results[] = new GamePlayerRecord([
                'gameRecordId'  => new GameRecordId($gameRecord->game_record_id),
                'playerMemory'  => new PlayerMemory([
                    'playerMemoryId'    => new PlayerMemoryId($gameRecord->player_memory_id),
                    'playerId'          => new PlayerId($gameRecord->player_id),
                    'team'              => new GameTeam($gameRecord->team),
                    'mu'                => new Mu($gameRecord->mu),
                    'afterMu'           => new Mu($gameRecord->afterMu),
                    'sigma'             => new Sigma($gameRecord->sigma),
                    'afterSigma'        => new Mu($gameRecord->afterSigma),
                    'rate'              => new Rate($gameRecord->rate),
                    'afterRate'         => new Mu($gameRecord->afterRate),
                ]),
                'gamePackageId' => new GamePackageId($gameRecord->game_package_id),
                'winningTeam'   => new GameTeam($gameRecord->winning_team),
                'status'        => new GameStatus($gameRecord->status),
                'startedAt'     => new Datetime($gameRecord->started_at),
                'finishedAt'    => new Datetime($gameRecord->finished_at),
            ]);
        }

        return $results;
    }
}
