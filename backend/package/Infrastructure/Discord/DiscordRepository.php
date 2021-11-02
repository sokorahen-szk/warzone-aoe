<?php declare(strict_types=1);

namespace Package\Infrastructure\Discord;

use Package\Domain\User\Entity\User;

class DiscordRepository implements DiscordRepositoryInterface {
    private  $discordClient;

    public function __construct(DiscordClientInterface $discordClient)
    {
        $this->discordClient = $discordClient;
    }

    /**
     * 会員登録時にDiscord通知する
     * @param User $user
     * @return void
     */
    public function registrationUserNotification(User $user): void
    {
        $this->discordClient->sendMessageOnTemplate(
            env('DISCORD_REGISTER_NOTIFICATION_WEBHOOK'),
            'register_notification_template',
            [
                'datetime'      => $user->getPlayer()->getJoinedAt()->getDatetime(),
                'userName'      => $user->getName()->getValue(),
                'playerName'    => $user->getPlayer()->getPlayerName()->getValue(),
                'packages'      => $user->getPlayer()->getGamePackages()->getValue(),
            ]
        );
    }
}