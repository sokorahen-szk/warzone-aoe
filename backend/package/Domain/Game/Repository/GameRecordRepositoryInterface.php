<?php declare(strict_types=1);

namespace Package\Domain\Game\Repository;

use Package\Domain\User\Entity\User;
use Package\Domain\System\ValueObject\Date;
use Package\Domain\System\Entity\Paginator;

interface GameRecordRepositoryInterface
{
    /**
    * 特定ユーザのレーティングを日付範囲で取得する
    * @param User $user
    * @param Date $beginDate
    * @param Date|null $endDate
    * @return array
    */
    public function listRaitingByUserWithDateRange(User $user, Date $beginDate, ?Date $endDate): array;

    /**
    * 対戦履歴を日付範囲で取得する
    * @param Paginator
    * @param Date $beginDate
    * @param Date|null $endDate
    * @return array
    */
    public function listHistoryByDateRange(Paginator $paginator, Date $beginDate, ?Date $endDate): array;
}
