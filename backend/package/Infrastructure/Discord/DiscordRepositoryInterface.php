<?php declare(strict_types=1);

namespace Package\Infrastructure\Discord;

use Package\Domain\Game\Entity\GameRecord;
use Package\Domain\User\Entity\User;
use Package\Domain\System\ValueObject\Datetime;

interface DiscordRepositoryInterface {
    /**
     * 会員登録時にDiscord通知する
     * @param User $user
     * @return void
     */
    public function registrationUserNotification(Datetime $registerDatetime, User $user): void;

    /**
     * ゲーム開始時にDiscord通知する
     *
     * @param GameRecord $gameRecord
     * @return void
     */
    public function startGameNotification(GameRecord $gameRecord): void;

    /**
     * ゲーム終了時にDiscord通知する
     *
     * @param GameRecord $gameRecord
     * @return void
     */
    public function endGameNotification(GameRecord $gameRecord): void;
}