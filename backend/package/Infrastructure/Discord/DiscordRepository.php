<?php declare(strict_types=1);

namespace Package\Infrastructure\Discord;

use Package\Domain\Game\Entity\GameRecord;
use Package\Domain\Game\ValueObject\GameRecord\GameTeam;
use Package\Domain\User\Entity\PlayerMemory;
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

    /**
     * ゲーム開始時にDiscord通知する
     *
     * @param GameRecord $gameRecord
     * @return void
     */
    public function startGameNotification(GameRecord $gameRecord): void
    {
        $gamePackageName = $gameRecord->getGamePackage()->getName()->getValue();
        $gameMapName = $gameRecord->getMap()->getName()->getValue();
        $notificationTitle = sprintf('%s %s', $gamePackageName, $gameMapName);
        $gameStartDatetime = $gameRecord->getStartedAt()->getDatetime();
        $team1RateSum = $gameRecord->getRateSum(new GameTeam(1));
        $team2RateSum = $gameRecord->getRateSum(new GameTeam(2));

        // TODO:
        $team1 = 'impl';
        $team2 = 'impl';

        $this->discordClient->sendMessageEmbeds(
            env('DISCORD_REGISTER_NOTIFICATION_WEBHOOK'),
            [
                'content'   => '',
                'embeds'    => [
                    [
                        'title' => $notificationTitle,
                        'description' => 'ゲーム開始',
                        'color' => 0x94c529,
                        'footer' => [
                            'text' => "ゲーム開始日時：$gameStartDatetime",
                        ],
                        'fields' => [
                            [
                                'name' => "チーム１【 $team1RateSum 】",
                                'value' => $team1,
                                'inline' => false
                            ],
                            [
                                'name' => "チーム２【 $team2RateSum 】",
                                'value' => $team2,
                                'inline' => false
                            ],
                        ]
                    ]
                ]
            ],
        );
    }
}