<?php declare(strict_types=1);

namespace Package\Infrastructure\Discord;

use Package\Domain\Game\Entity\GameRecord;
use Package\Domain\Game\ValueObject\GameRecord\GameTeam;
use Package\Domain\User\Entity\User;
use Config;
use Package\Domain\User\ValueObject\Player\Rate;

class DiscordRepository implements DiscordRepositoryInterface {
    private  $discordClient;

    const GAME_START = 'game_start';
    const GAME_END = 'game_end';

    private static $gameTypes = [
        self::GAME_START => 'ゲーム開始',
        self::GAME_END => 'ゲーム終了',
    ];

    public function __construct(DiscordClientInterface $discordClient)
    {
        $this->discordClient = $discordClient;

        $this->config = Config::get('notification');
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
        $gameMapName = $gameRecord->getGameMap()->getName()->getValue();
        $notificationTitle = sprintf('%s %s', $gamePackageName, $gameMapName);
        $notificationColor = $this->config->embed_color->info;
        $gameStartDatetime = $gameRecord->getStartedAt()->getDatetime();

        $team1 = new GameTeam(1);
        $team2 = new GameTeam(2);
        $team1RateSum = $gameRecord->getRateSum($team1);
        $team2RateSum = $gameRecord->getRateSum($team2);
        $team1List = $gameRecord->pluckPlayerMemoriesByTeam($team1);
        $team2List = $gameRecord->pluckPlayerMemoriesByTeam($team2);

        $this->sendGameNotidication(
            self::GAME_START,
            $notificationTitle,
            $notificationColor,
            $gameStartDatetime,
            $team1RateSum,
            $team2RateSum,
            $team1List,
            $team2List
        );
    }

    /**
     * ゲーム終了時にDiscord通知する
     *
     * @param GameRecord $gameRecord
     * @return void
     */
    public function endGameNotification(GameRecord $gameRecord): void
    {
        $gamePackageName = $gameRecord->getGamePackage()->getName()->getValue();
        $gameMapName = $gameRecord->getGameMap()->getName()->getValue();
        $notificationTitle = sprintf('%s %s', $gamePackageName, $gameMapName);
        $notificationColor = $this->config->embed_color->success;
        $gameEndDatetime = $gameRecord->getFinishedAt()->getDatetime();

        $team1 = new GameTeam(1);
        $team2 = new GameTeam(2);
        $team1RateSum = $gameRecord->getRateSum($team1);
        $team2RateSum = $gameRecord->getRateSum($team2);
        $team1List = $gameRecord->pluckPlayerMemoriesByTeam($team1);
        $team2List = $gameRecord->pluckPlayerMemoriesByTeam($team2);

        $this->sendGameNotidication(
            self::GAME_END,
            $notificationTitle,
            $notificationColor,
            $gameEndDatetime,
            $team1RateSum,
            $team2RateSum,
            $team1List,
            $team2List
        );
    }

    private function sendGameNotidication(
        string $gameMode,
        string $notificationTitle,
        int $notificationColor,
        string $gameDatetime,
        int $team1RateSum,
        int $team2RateSum,
        array $team1List,
        array $team2List
    )
    {
        $this->discordClient->sendMessageEmbeds(
            env('DISCORD_GAME_NOTIFICATION_WEBHOOK'),
            [
                'content'   => '',
                'embeds'    => [
                    [
                        'title' => $notificationTitle,
                        'description' => self::$gameTypes[$gameMode],
                        'color' => $notificationColor,
                        'footer' => [
                            'text' => sprintf('%s日時：%s', self::$gameTypes[$gameMode], $gameDatetime),
                        ],
                        'fields' => [
                            [
                                'name' => "チーム１【 $team1RateSum 】",
                                'value' => $this->generateTeamListToString($gameMode, $team1List),
                                'inline' => false
                            ],
                            [
                                'name' => "チーム２【 $team2RateSum 】",
                                'value' => $this->generateTeamListToString($gameMode, $team2List),
                                'inline' => false
                            ],
                        ]
                    ]
                ]
            ],
        );
    }

    /**
     * @param string $gameMode
     * @param PlayerMemory[] $playerMemories
     * @return string
     */
    private function generateTeamListToString(string $gameMode, array $playerMemories): string
    {
        $teamList = [];
        foreach ($playerMemories as $idx => $playerMemory) {
            if ($gameMode == self::GAME_START) {
                $teamList[] = sprintf(
                    '%d　%s(%d)',
                    $idx + 1,
                    $playerMemory->getPlayer()->getPlayerName()->getValue(),
                    $playerMemory->getRate()->getValue(),
                );
            } else {
                $rate = new Rate($playerMemory->getRate()->diff($playerMemory->getAfterRate()));
                $teamList[] = sprintf(
                    '%d　%s(%d)<%s>',
                    $idx + 1,
                    $playerMemory->getPlayer()->getPlayerName()->getValue(),
                    $playerMemory->getRate()->getValue(),
                    $rate->getValueInSign()
                );
            }
        }

        return implode("\n", $teamList);
    }
}