<?php declare(strict_types=1);

namespace Package\Infrastructure\Discord;

use Package\Domain\Game\Entity\GameRecord;
use Package\Domain\Game\ValueObject\GameRecord\GameTeam;
use Package\Domain\User\Entity\User;
use Config;
use Package\Domain\System\ValueObject\Datetime;
use Package\Domain\User\ValueObject\Player\Rate;

use \Package\Domain\Game\Entity\GamePackage;
use Package\Domain\User\ValueObject\Player\GamePackages;

use Package\Domain\User\ValueObject\RegisterQuestion;

class DiscordRepository implements DiscordRepositoryInterface {
    private  $discordClient;

    const GAME_START = 'game_start';
    const GAME_END = 'game_end';

    const LINE_RETURN_CHAR = '
';

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
     * @param Datetime $registerDatetime
     * @param User $user
     * @param RegisterQuestion $registerQuestion
     * @param GamePackage[] $gamePackages
     * @return void
     */
    public function registrationUserNotification(Datetime $registerDatetime, User $user, RegisterQuestion $registerQuestion, array $gamePackages): void
    {
        $entities = $this->filterGamePackages($user->getPlayer()->getGamePackages(), $gamePackages);
        $packages = [];
        foreach ($entities as $entity) {
            $packages[] =  $entity->getName()->getValue();
        }

        $this->discordClient->sendMessageOnTemplate(
            env('DISCORD_REGISTER_NOTIFICATION_WEBHOOK'),
            'register_notification_template',
            [
                'datetime'                  => $registerDatetime->getDatetime(),
                'userName'                  => $user->getName()->getValue(),
                'playerName'                => $user->getPlayer()->getPlayerName()->getValue(),
                'packages'                  => implode(self::LINE_RETURN_CHAR, $packages),
                'arabiaGameExperienceCount' => implode(self::LINE_RETURN_CHAR, $registerQuestion->getAnswer1()->getList()),
                'tactics'                   => implode(self::LINE_RETURN_CHAR, $registerQuestion->getAnswer2()->getList()),
                'communityJoined'           => implode(self::LINE_RETURN_CHAR, $registerQuestion->getAnswer3()->getList()),
                'appUrl'                    => env('APP_URL'),
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
            $team2List,
            null
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

        $winnerTeam = $gameRecord->getWinningTeam();
        $winnerTeamLabel = null;
        if ($winnerTeam->getValue() === 1 || $winnerTeam->getValue() === 2) {
            $winnerTeamLabel = sprintf('チーム%d 勝利', $winnerTeam->getValue());
        }

        $this->sendGameNotidication(
            self::GAME_END,
            $notificationTitle,
            $notificationColor,
            $gameEndDatetime,
            $team1RateSum,
            $team2RateSum,
            $team1List,
            $team2List,
            $winnerTeamLabel
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
        array $team2List,
        ?string $winnerTeamLabel
    )
    {
        $this->discordClient->sendMessageEmbeds(
            env('DISCORD_GAME_NOTIFICATION_WEBHOOK'),
            [
                'content'   => '',
                'embeds'    => [
                    [
                        'title' => $notificationTitle,
                        'description' => $this->generateDescription(
                            [
                                self::$gameTypes[$gameMode],
                                $winnerTeamLabel,
                            ]
                        ),
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
                $rate = new Rate($playerMemory->getAfterRate()->diff($playerMemory->getRate()));
                $teamList[] = sprintf(
                    '%d　%s(%d)<%s>',
                    $idx + 1,
                    $playerMemory->getPlayer()->getPlayerName()->getValue(),
                    $playerMemory->getAfterRate()->getValue(),
                    $rate->getValueInSign()
                );
            }
        }

        return implode("\n", $teamList);
    }

    /**
     * @param GamePackages $gamePackages
     * @param GamePackage[] $entities
     * @return GamePackage[]
     */
    private function filterGamePackages(GamePackages $gamePackages, array $entities)
    {
        $filterdGamePackages = [];
        $gamePackageIdAsTextList = $gamePackages->getList();
        foreach ($gamePackageIdAsTextList as $gamePackageIdAsText) {
            foreach ($entities as $entity) {
                if ((int) $gamePackageIdAsText === $entity->getGamePackageId()->getValue()) {
                    $filterdGamePackages[] = $entity;
                }
            }
        }

        return $filterdGamePackages;
    }

    /**
     * @param array $descriptions
     * @return string
     */
    private function generateDescription(array $descriptions): string
    {
        if (count($descriptions) === 1) {
            return $descriptions[0];
        }

        $descriptionStr = null;
        foreach ($descriptions as $description) {
            if ($description == null) {
                continue;
            }

            $descriptionStr .= sprintf('%s%s', $description, self::LINE_RETURN_CHAR);
        }

        return $descriptionStr;
    }

}