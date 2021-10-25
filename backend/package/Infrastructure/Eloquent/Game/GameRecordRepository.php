<?php declare(strict_types=1);

namespace Package\Infrastructure\Eloquent\Game;

use Package\Domain\Game\Repository\GameRecordRepositoryInterface;
use Package\Domain\System\ValueObject\Date;
use App\Models\GameRecordModel as EloquentGameRecordModel;

use Package\Domain\Game\ValueObject\GameRecord\GameRecordId;
use Package\Domain\Game\ValueObject\GamePackage\GamePackageId;
use Package\Domain\Game\ValueObject\GameRecord\GameStatus;
use Package\Domain\Game\ValueObject\GameRecord\VictoryPrediction;
use Package\Domain\User\Entity\User;
use Package\Domain\Game\Entity\GamePlayerRecord;
use Package\Domain\Game\Entity\GameRecord;
use Package\Domain\User\ValueObject\UserId;
use Package\Domain\System\Entity\Paginator;
use Package\Domain\Game\ValueObject\GameMap\GameMapId;
use Package\Domain\Game\ValueObject\GameRule\GameRuleId;
use Package\Infrastructure\Eloquent\Converter;

class GameRecordRepository implements GameRecordRepositoryInterface
{
    /**
     * 試合記録作成
     *
     * @param UserId|null $userId
     * @param GamePackageId $gamePackageId
     * @param GameMapId $gameMapId
     * @param GameRuleId $gameRuleId
     * @param VictoryPrediction $victoryPrediction
     * @return GameRecordId
     */
    public function create(?UserId $userId, GamePackageId $gamePackageId, GameMapId $gameMapId,
    GameRuleId $gameRuleId, VictoryPrediction $victoryPrediction): GameRecordId
    {
        $gameRecord = EloquentGameRecordModel::create([
            'game_package_id' => $gamePackageId->getValue(),
            'user_id' => $userId ? $userId->getValue() : null,
            'rule_id' => $gameRuleId->getValue(),
            'map_id' => $gameMapId->getValue(),
            'victory_prediction' => $victoryPrediction->getPerInt(),
            'status' => GameStatus::GAME_STATUS_MATCHING,
            'started_at' => now()->toDateTimeString(),
        ]);

        return new GameRecordId($gameRecord->id);
    }

    /**
    * 特定ユーザのレーティングを日付範囲で取得する
    * @param User $user
    * @param Date $beginDate
    * @param Date|null $endDate
    * @return GamePlayerRecord[]
    */
    public function listRaitingByUserWithDateRange(User $user, Date $beginDate, ?Date $endDate): array
    {
        $gameRecords = EloquentGameRecordModel::with('player_memories')
            ->whereStartedAtByDateRange($beginDate, $endDate)
            ->whereIn('status', [GameStatus::GAME_STATUS_DRAW, GameStatus::GAME_STATUS_FINISHED])
            ->whereHasByPlayerMemory($user->getPlayer()->getPlayerId())
            ->get();

        return Converter::gamePlayerRecords($gameRecords);
    }

    /**
    * 対戦履歴を日付範囲で取得する
    * @param Paginator
    * @param Date $beginDate
    * @param Date $endDate
    * @return array<GameRecord>
    */
    public function listHistoryByDateRange(Paginator $paginator, Date $beginDate, Date $endDate): array
    {
        $gameRecords = EloquentGameRecordModel::with([
            'game_package',
            'player_memories.player.user',
            'map',
            'rule',
        ])
        ->whereStartedAtByDateRange($beginDate, $endDate)
        ->orderBy('id', 'DESC')
        ->offset($paginator->getNextOffset())
        ->limit($paginator->getLimit()->getValue())
        ->get();

        return Converter::gameRecords($gameRecords);
    }

    /**
    * 対戦履歴を日付範囲で取得し、総件数を返す
    * @param Date $beginDate
    * @param Date $endDate
    * @return int
    */
    public function listHistoryByDateRangeCount(Date $beginDate, Date $endDate): int
    {
        $count = EloquentGameRecordModel::whereStartedAtByDateRange($beginDate, $endDate)
        ->count();

        return $count;
    }

    /**
    * 特定ユーザの対戦履歴を日付範囲で取得する
    * @param User $user
    * @param Paginator $paginator
    * @param Date $beginDate
    * @param Date $endDate
    * @return array<GamePlayerRecord>
    */
    public function listHistoryByUserWithDateRange(User $user, Paginator $paginator, Date $beginDate, Date $endDate): array
    {
        $gameRecords = EloquentGameRecordModel::with([
            'game_package',
            'player_memories.player.user',
            'map',
            'rule',
        ])
        ->whereStartedAtByDateRange($beginDate, $endDate)
        ->orderBy('id', 'DESC')
        ->offset($paginator->getNextOffset())
        ->limit($paginator->getLimit()->getValue())
        ->whereHasByPlayerMemory($user->getPlayer()->getPlayerId())
        ->get();

        return Converter::gameRecords($gameRecords);
    }

    /**
    * 特定ユーザの対戦履歴を日付範囲で取得し、総件数を返す
    * @param User $user
    * @param Date $beginDate
    * @param Date $endDate
    * @return int
    */
    public function listHistoryByUserWithDateRangeCount(User $user, Date $beginDate, Date $endDate): int
    {
        $count = EloquentGameRecordModel::whereStartedAtByDateRange($beginDate, $endDate)
            ->whereHasByPlayerMemory($user->getPlayer()->getPlayerId())
        ->count();

        return $count;
    }

    /**
     * 特定のステータスでデータを抽出する
     * @param GameStatus $status
     * @return array<GamePlayerRecord>
     */
    public function listHistoryByStatus(GameStatus $status): array
    {
        $gameRecords = EloquentGameRecordModel::with('player_memories')
        ->where('status', $status->getValue())
        ->get();

        return Convert::gameRecords($gameRecords);
    }
}
