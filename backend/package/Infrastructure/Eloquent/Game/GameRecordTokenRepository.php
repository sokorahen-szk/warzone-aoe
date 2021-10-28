<?php declare(strict_types=1);

namespace Package\Infrastructure\Eloquent\Game;

use Package\Domain\Game\Repository\GameRecordTokenRepositoryInterface;
use App\Models\GameRecordTokenModel as EloquentGameRecordToken;
use Package\Domain\Game\ValueObject\GameRecordToken\GameToken;
use Package\Domain\Game\Entity\GameRecordToken;
use Package\Infrastructure\Eloquent\Converter;
use Package\Infrastructure\Eloquent\Token;
use Package\Domain\Game\ValueObject\GameRecord\GameRecordId;
use Package\Domain\System\ValueObject\Datetime;

class GameRecordTokenRepository implements GameRecordTokenRepositoryInterface
{
    /**
     * ゲームレコードトークン作成
     *
     * @param GameRecordId $gameRecordId
     * @param Datetime $expiresAt
     * @return GameRecordToken
     */
    public function create(GameRecordId $gameRecordId, Datetime $expiresAt): GameRecordToken
    {
        $gameRecordToken = EloquentGameRecordToken::create([
            'game_record_id' => $gameRecordId->getValue(),
            'game_token' => Token::generate(),
            'expires_at' => $expiresAt->getDatetime(),
        ]);

        return Converter::gameRecordToken($gameRecordToken);
    }

    /**
     * ゲームトークンから情報を取得する
     *
     * @param GameToken $gameToken
     * @return GameRecordToken
     */
    public function getByGameToken(GameToken $gameToken): GameRecordToken
    {
        $gameRecordToken = EloquentGameRecordToken::where('game_token', $gameToken->getValue())
            ->first();

        return Converter::gameRecordToken($gameRecordToken);
    }
}