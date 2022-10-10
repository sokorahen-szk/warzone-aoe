<?php declare(strict_types=1);

namespace Package\Infrastructure\Eloquent\Game;

use Package\Domain\Game\Repository\GameRecordRepositoryInterface;
use Package\Domain\System\ValueObject\Date;
use App\Models\GameRecordModel as EloquentGameRecordModel;

use Package\Domain\Game\ValueObject\GameRecord\GameRecordId;
use Package\Domain\Game\ValueObject\GamePackage\GamePackageId;
use Package\Domain\Game\ValueObject\GameRecord\GameStatus;
use Package\Domain\Game\ValueObject\GameRecord\VictoryPrediction;
use Package\Domain\Game\ValueObject\GameRecord\IsRating;
use Package\Domain\User\Entity\User;
use Package\Domain\Game\Entity\GamePlayerRecord;
use Package\Domain\User\ValueObject\UserId;
use Package\Domain\System\Entity\Paginator;
use Package\Domain\Game\ValueObject\GameMap\GameMapId;
use Package\Domain\Game\ValueObject\GameRule\GameRuleId;
use Package\Infrastructure\Eloquent\Converter;
use Package\Domain\Game\Entity\GameRecord;

use Illuminate\Database\Eloquent\ModelNotFoundException;


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
     * @param IsRating $isRating
     * @return GameRecordId
     */
    public function create(?UserId $userId, GamePackageId $gamePackageId, GameMapId $gameMapId,
    GameRuleId $gameRuleId, VictoryPrediction $victoryPrediction, IsRating $isRating): GameRecordId
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
     * ゲームレコードを取得する
     *
     * @param GameRecordId $gameRecordId
     * @return GameRecord
     */
    public function getById(GameRecordId $gameRecordId): GameRecord
    {
        try {
            $gameRecord = EloquentGameRecordModel::with([
                'game_package',
                'player_memories.player.user',
                'map',
                'rule',
            ])
                ->findOrFail($gameRecordId->getValue());
        } catch (ModelNotFoundException $e) {
            Log::Info($e->getMessage());
            throw new ModelNotFoundException(sprintf("ゲームレコードID %d の情報が存在しません。", $gameRecordId->getValue()));
        }

        return Converter::gameRecord($gameRecord);
    }

    /**
     * 試合記録更新
     *
     * @param GameRecord $gameRecord
     * @return void
     */
    public  function update(GameRecord $gameRecord): void
    {
        try {
            EloquentGameRecordModel::findOrFail($gameRecord->getGameRecordId()->getValue())
                ->update([
                    'status' => $gameRecord->getGameStatus()->getValue(),
                    'winning_team' => $gameRecord->getWinningTeam()->getValue(),
                    'finished_at' => $gameRecord->getFinishedAt()->getDatetime(),
                ]);
        } catch (ModelNotFoundException $e) {
            Log::Info($e->getMessage());
            throw new ModelNotFoundException(sprintf("ゲームレコードID %d の情報が存在しません。", $gameRecord->getGameRecordId()->getValue()));
        }
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
        $playerId = $user->getPlayer()->getPlayerId();
        $gameRecords = EloquentGameRecordModel::with(["player_memories" => function($query) use ($playerId) {
            $query->where("player_id", $playerId->getValue());
        }])
        ->whereStartedAtByDateRange($beginDate, $endDate)
        ->whereIn('status', [GameStatus::GAME_STATUS_DRAW, GameStatus::GAME_STATUS_FINISHED])
        ->whereHasByPlayerMemory($playerId)
        ->get();

        return Converter::gamePlayerRecords($gameRecords);
    }

    /**
    * 対戦履歴を日付範囲で取得する
    * @param Paginator
    * @param Date $beginDate
    * @param Date $endDate
    * @param GameStatus|null $gameStatus
    * @return GameRecord[]
    */
    public function listHistoryByDateRange(Paginator $paginator, Date $beginDate, Date $endDate, ?GameStatus $gameStatus): array
    {
        $gameRecords = EloquentGameRecordModel::with([
            'game_package',
            'player_memories.player.user',
            'map',
            'rule',
        ])
        ->whereStartedAtByDateRange($beginDate, $endDate)
        ->whereGameStatus($gameStatus)
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
    * @param GameStatus|null $gameStatus
    * @return int
    */
    public function listHistoryByDateRangeCount(Date $beginDate, Date $endDate, ?GameStatus $gameStatus): int
    {
        $count = EloquentGameRecordModel::whereStartedAtByDateRange($beginDate, $endDate)
        ->whereGameStatus($gameStatus)
        ->count();

        return $count;
    }

    /**
    * 特定ユーザの対戦履歴を日付範囲で取得する
    * @param User $user
    * @param Paginator $paginator
    * @param Date $beginDate
    * @param Date $endDate
    * @return GamePlayerRecord[]
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
     * @return GamePlayerRecord[]
     */
    public function listHistoryByStatus(GameStatus $status): array
    {
        $gameRecords = EloquentGameRecordModel::with([
            'game_package',
            'player_memories.player.user',
            'map',
            'rule',
        ])
        ->where('status', $status->getValue())
        ->get();

        return Converter::gameRecords($gameRecords);
    }

    /**
     * 特定ユーザとステータスでデータを抽出する
     *
     * @param User $user
     * @param GameStatus $status
     * @return GamePlayerRecord[]
     */
    public function listHistoryByUsserWithStatus(User $user, GameStatus $status): array
    {
        $gameRecords = EloquentGameRecordModel::with([
            'game_package',
            'player_memories.player.user',
            'map',
            'rule',
        ])
        ->where('status', $status->getValue())
        ->where('user_id', $user->getId()->getValue())
        ->orderBy('id', 'DESC')
        ->get();

        return Converter::gameRecords($gameRecords);
    }
}
