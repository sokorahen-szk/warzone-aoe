<?php declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Discord;

use Package\Domain\System\ValueObject\Datetime;
use Package\Domain\User\Entity\Player;
use Package\Domain\User\Entity\User;
use Package\Domain\User\ValueObject\Name;
use Package\Domain\User\ValueObject\Player\GamePackages;
use Package\Domain\User\ValueObject\Player\PlayerName;
use Package\Infrastructure\Discord\DiscordClient;
use Package\Infrastructure\Discord\DiscordRepository;
use Tests\TestCase;

class DiscordRepositoryTest extends TestCase {
    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = new User([
            'name' => new Name('user name'),
            'player' => new Player([
                'playerName' => new PlayerName('player name'),
                'gamePackages' => new GamePackages('1,2,3'),
                'joinedAt' => new Datetime('2021-01-01 00:00:00'),
            ]),
        ]);
    }

    public function test_registration_user_notification()
    {
        $discordRepository = new DiscordRepository(new DiscordClient());
        $discordRepository->registrationUserNotification($this->user);
        $this->assertTrue(true);
    }
}