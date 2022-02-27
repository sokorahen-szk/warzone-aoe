<?php declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Discord;

use Package\Domain\Game\Entity\GamePackage;
use Package\Domain\Game\ValueObject\GamePackage\GamePackageId;
use Package\Domain\System\ValueObject\Datetime;
use Package\Domain\System\ValueObject\Description;
use Package\Domain\User\Entity\Player;
use Package\Domain\User\Entity\User;
use Package\Domain\User\ValueObject\Name as UserName;
use Package\Domain\System\ValueObject\Name;
use Package\Domain\User\ValueObject\Player\GamePackages;
use Package\Domain\User\ValueObject\Player\PlayerName;
use Package\Domain\User\ValueObject\RegisterAnswer;
use Package\Domain\User\ValueObject\RegisterQuestion;
use Package\Infrastructure\Discord\DiscordClient;
use Package\Infrastructure\Discord\DiscordRepository;
use Tests\TestCase;

class DiscordRepositoryTest extends TestCase {
    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = new User([
            'name' => new UserName('user name'),
            'player' => new Player([
                'playerName' => new PlayerName('player name'),
                'gamePackages' => new GamePackages('1,2,3'),
                'joinedAt' => new Datetime('2021-01-01 00:00:00'),
            ]),
            ''
        ]);
    }

    public function test_registration_user_notification()
    {

        $datetime = new Datetime(now());

        $gamePackages = [
            new GamePackage([
                'gamePackageId' => new GamePackageId(1),
                'name'          => new Name("錬金３級まじかるぽか〜ん"),
                'description'   => new Description("test test test 1"),
            ]),
            new GamePackage([
                'gamePackageId' => new GamePackageId(2),
                'name'          => new Name("突き刺せ呂布子ちゃん"),
                'description'   => new Description("test test test 2"),
            ]),
            new GamePackage([
                'gamePackageId' => new GamePackageId(99),
                'name'          => new Name("test99"),
                'description'   => new Description("test test test 99"),
            ]),
        ];

        $registerQuestion = new RegisterQuestion(
            new RegisterAnswer("バナナ"),
            new RegisterAnswer("リンゴ"),
            new RegisterAnswer("パイナップル")
        );

        $discordRepository = new DiscordRepository(new DiscordClient());
        $discordRepository->registrationUserNotification($datetime, $this->user, $registerQuestion, $gamePackages);
        $this->assertTrue(true);
    }
}