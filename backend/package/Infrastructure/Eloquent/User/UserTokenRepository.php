<?php declare(strict_types=1);

namespace Package\Infrastructure\Eloquent\User;

use Package\Domain\System\ValueObject\Datetime;
use Package\Domain\System\ValueObject\Token;
use Package\Domain\User\Repository\UserTokenRepositoryInterface;
use Package\Domain\User\ValueObject\UserId;

use App\Models\UserTokenModel as EloquentUserToken;
use Package\Domain\User\ValueObject\Email;

class UserTokenRepository implements UserTokenRepositoryInterface {
    /**
     * @param UserId $userId
     * @param Email $email
     * @param Token $token
     * @param Datetime $expireAt
     * @return void
     */
    public function save(UserId $userId, Email $email, Token $token, Datetime $expireAt)
    {
        EloquentUserToken::updateOrCreate(
            [
                'user_id' => $userId->getValue(),
            ],
            [
                'email' => $email->getValue(),
                'token' => $token->getValue(),
                'expire_at' => $expireAt->getDatetime(),
            ],
        );
    }
}