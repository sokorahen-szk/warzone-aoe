<?php declare(strict_types=1);

namespace Package\Infrastructure\Eloquent\User;

use Package\Domain\System\ValueObject\Datetime;
use Package\Domain\System\ValueObject\Token;
use Package\Domain\User\Repository\UserTokenRepositoryInterface;
use Package\Domain\User\ValueObject\UserId;

use App\Models\UserTokenModel as EloquentUserToken;
use Package\Domain\User\Entity\UserToken;
use Package\Domain\User\ValueObject\Email;
use Package\Domain\User\ValueObject\UserToken\UserTokenId;
use Package\Infrastructure\Eloquent\Converter;
use Exception;

class UserTokenRepository implements UserTokenRepositoryInterface {
    /**
     * @param UserId $userId
     * @param Email $email
     * @param Token $token
     * @param Datetime $expireAt
     * @return void
     */
    public function save(UserId $userId, Email $email, Token $token, Datetime $expiresAt)
    {
        EloquentUserToken::updateOrCreate(
            [
                'user_id' => $userId->getValue(),
            ],
            [
                'email' => $email->getValue(),
                'token' => $token->getEncrypted(),
                'expires_at' => $expiresAt->getDatetime(),
            ],
        );
    }

    /**
     * @param Token $token
     * @return UserToken
     */
    public function getByToken(Token $token): UserToken
    {
        $userToken = EloquentUserToken::where('token', $token->getValue())->first();

        if (!$userToken) {
            throw new Exception('パスワード再発行に必要なデータが存在しません。');
        }

        return Converter::userToken($userToken);
    }

    /**
     * @param UserTokenId $userTokenId
     * @return void
     */
    public function delete(UserTokenId $userTokenId): void
    {
        EloquentUserToken::where('id', $userTokenId->getValue())->delete();
    }
}