<?php declare(strict_types=1);

namespace Package\Domain\User\Repository;

use Package\Domain\System\ValueObject\Token;
use Package\Domain\System\ValueObject\Datetime;
use Package\Domain\User\Entity\UserToken;
use Package\Domain\User\ValueObject\Email;
use Package\Domain\User\ValueObject\UserId;
use Package\Domain\User\ValueObject\UserToken\UserTokenId;

interface UserTokenRepositoryInterface {
    /**
     * @param UserId $userId
     * @param Email $email
     * @param Token $token
     * @param Datetime $expiresAt
     * @return void
     */
    public function save(UserId $userId, Email $email, Token $token, Datetime $expiresAt);

    /**
     * @param Token $token
     * @return UserToken
     */
    public function getByToken(Token $token): UserToken;

    /**
     * @param UserTokenId $userTokenId
     * @return void
     */
    public function delete(UserTokenId $userTokenId): void;
}