<?php declare(strict_types=1);

namespace Package\Domain\User\Repository;

use Package\Domain\System\ValueObject\Token;
use Package\Domain\System\ValueObject\Datetime;
use Package\Domain\User\ValueObject\Email;
use Package\Domain\User\ValueObject\UserId;

interface UserTokenRepositoryInterface {
    /**
     * @param UserId $userId
     * @param Email $email
     * @param Token $token
     * @param Datetime $expireAt
     * @return void
     */
    public function save(UserId $userId, Email $email, Token $token, Datetime $expireAt);
}