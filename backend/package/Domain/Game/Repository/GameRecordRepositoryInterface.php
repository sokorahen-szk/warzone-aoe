<?php declare(strict_types=1);

namespace Package\Domain\Game\Repository;

use Package\Domain\User\Entity\User;
use Package\Domain\System\ValueObject\Date;
use Package\Domain\System\Entity\Paginator;
use Package\Domain\Game\ValueObject\GameRecord\GameStatus;
use Package\Domain\Game\ValueObject\GamePackage\GamePackageId;

interface GameRecordRepositoryInterface
{
    /**
    * 特定ユーザのレーティングを日付範囲で取得する
    * @param User $user
    * @param GamePackageId $gamePackageId
    * @param Date $beginDate
    * @param Date|null $endDate
    * @return GamePlayerRecord[]
    */
    public function listRaitingByUserWithDateRange(User $user, GamePackageId $gamePackageId, Date $beginDate, ?Date $endDate): array;

    /**
    * 対戦履歴を日付範囲で取得する
    * @param GamePackageId $gamePackageId
    * @param Paginator
    * @param Date $beginDate
    * @param Date $endDate
    * @return GameRecord[]
    */
    public function listHistoryByDateRange(GamePackageId $gamePackageId, Paginator $paginator,Date $beginDate, Date $endDate): array;

    /**
    * 対戦履歴を日付範囲で取得し、総件数を返す
    * @param GamePackageId $gamePackageId
    * @param Date $beginDate
    * @param Date $endDate
    * @return int
    */
    public function listHistoryByDateRangeCount(GamePackageId $gamePackageId, Date $beginDate, Date $endDate): int;

    /**
    * 特定ユーザの対戦履歴を日付範囲で取得する
    * @param User $user
    * @param GamePackageId $gamePackageId
    * @param Paginator $paginator
    * @param Date $beginDate
    * @param Date $endDate
    * @return GamePlayerRecord[]
    */
    public function listHistoryByUserWithDateRange(User $user, GamePackageId $gamePackageId, Paginator $paginator, Date $beginDate, Date $endDate): array;

    /**
    * 特定ユーザの対戦履歴を日付範囲で取得し、総件数を返す
    * @param User $user
    * @param GamePackageId $gamePackageId
    * @param Date $beginDate
    * @param Date $endDate
    * @return int
    */
    public function listHistoryByUserWithDateRangeCount(User $user, GamePackageId $gamePackageId, Date $beginDate, Date $endDate): int;

    /**
     * 特定のステータスでデータを抽出する
     * @param GameStatus $status
     * @return GamePlayerRecord[]
     */
    public function listHistoryByStatus(GameStatus $status): array;
}
