<?php declare(strict_types=1);

namespace Package\Domain\Game\Repository;

use Package\Domain\Game\ValueObject\GameRecord\GameRecordId;
use Package\Domain\Game\ValueObject\GameRecordToken\GameToken;
use Package\Domain\Game\Entity\GameRecordToken;
use Package\Domain\System\ValueObject\Datetime;

interface GameRecordTokenRepositoryInterface
{
    /**
     * ゲームレコードトークン作成
     *
     * @param GameRecordId $gameRecordId
     * @param Datetime $expiresAt
     * @return GameRecordToken
     */
    public function create(GameRecordId $gameRecordId, Datetime $expiresAt): GameRecordToken;

    /**
     * ゲームトークンから情報を取得する
     *
     * @param GameToken $gameToken
     * @return GameRecordToken
     */
    public function getByGameToken(GameToken $gameToken): GameRecordToken;
}
