<?php declare(strict_types=1);

namespace Package\Domain\Game\Repository;

use Package\Domain\User\Entity\User;
use Package\Domain\System\ValueObject\Date;
use Package\Domain\System\Entity\Paginator;
use Package\Domain\Game\ValueObject\GameRecord\GameStatus;
use Package\Domain\Game\ValueObject\GameRecord\GameRecordId;
use Package\Domain\Game\ValueObject\GameRecord\VictoryPrediction;
use Package\Domain\Game\ValueObject\GamePackage\GamePackageId;
use Package\Domain\Game\ValueObject\GameMap\GameMapId;
use Package\Domain\Game\ValueObject\GameRule\GameRuleId;
use Package\Domain\User\ValueObject\UserId;
use Package\Domain\Game\Entity\GameRecord;
use Package\Domain\Game\ValueObject\GameRecord\GameTeam;

interface GameRecordRepositoryInterface
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
    GameRuleId $gameRuleId, VictoryPrediction $victoryPrediction): GameRecordId;

    /**
     * ゲームレコードを取得する
     *
     * @param GameRecordId $gameRecordId
     * @return GameRecord
     */
    public function getById(GameRecordId $gameRecordId): GameRecord;

    /**
     * 試合記録更新
     *
     * @param GameRecord $gameRecord
     * @return void
     */
    public  function update(GameRecord $gameRecord): void;

    /**
    * 特定ユーザのレーティングを日付範囲で取得する
    * @param User $user
    * @param Date $beginDate
    * @param Date|null $endDate
    * @return GamePlayerRecord[]
    */
    public function listRaitingByUserWithDateRange(User $user, Date $beginDate, ?Date $endDate): array;

    /**
    * 対戦履歴を日付範囲で取得する
    * @param Paginator
    * @param Date $beginDate
    * @param Date $endDate
    * @return GameRecord[]
    */
    public function listHistoryByDateRange(Paginator $paginator, Date $beginDate, Date $endDate): array;

    /**
    * 対戦履歴を日付範囲で取得し、総件数を返す
    * @param Date $beginDate
    * @param Date $endDate
    * @return int
    */
    public function listHistoryByDateRangeCount(Date $beginDate, Date $endDate): int;

    /**
    * 特定ユーザの対戦履歴を日付範囲で取得する
    * @param User $user
    * @param Paginator $paginator
    * @param Date $beginDate
    * @param Date $endDate
    * @return GamePlayerRecord[]
    */
    public function listHistoryByUserWithDateRange(User $user, Paginator $paginator, Date $beginDate, Date $endDate): array;

    /**
    * 特定ユーザの対戦履歴を日付範囲で取得し、総件数を返す
    * @param User $user
    * @param Date $beginDate
    * @param Date $endDate
    * @return int
    */
    public function listHistoryByUserWithDateRangeCount(User $user, Date $beginDate, Date $endDate): int;

    /**
     * 特定のステータスでデータを抽出する
     * @param GameStatus $status
     * @return GamePlayerRecord[]
     */
    public function listHistoryByStatus(GameStatus $status): array;
}
