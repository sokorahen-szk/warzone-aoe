<?php declare(strict_types=1);

namespace Package\Domain\Game\Repository;

use Package\Domain\User\Entity\User;
use Package\Domain\System\ValueObject\Date;

interface GameRecordRepositoryInterface
{
    /**
     * 対戦履歴を日付範囲で取得する
     * @return array|null
     */
    public function listByDateRange(User $user, Date $beginDate, ?Date $endDate): ?array;
}
