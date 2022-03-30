<?php

namespace Tests\Feature\Application\Account\Register;

use Database\Seeders\GamePackageSeeder;
use Database\Seeders\RoleSeeder;
use Package\Application\Account\Register\AccountRegisterService;
use Package\Usecase\Account\Register\AccountRegisterCommand;
use Tests\TestCase;
use Package\Domain\User\Service\UserService;
use Package\Infrastructure\Discord\DiscordClient;
use Package\Infrastructure\Discord\DiscordRepository;
use Package\Infrastructure\Eloquent\Game\GamePackageRepository;
use Package\Infrastructure\Eloquent\Player\PlayerRepository;
use Package\Infrastructure\Eloquent\User\RegisterRequestRepository;
use Package\Infrastructure\Eloquent\User\UserRepository;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Package\Infrastructure\TrueSkill\TrueSkillClient;

class AccountRegisterServiceTest extends TestCase {
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_register_account()
    {
        $this->seed(GamePackageSeeder::class);
        $this->seed(RoleSeeder::class);

        $command = new AccountRegisterCommand(
            "username",
            "playerName",
            "password123",
            "email@example.com",
            "1,2",
            "0",
            "1,2,3",
            "3,4,5,6"
        );

        $userRepository = new UserRepository();

        $instance = new AccountRegisterService(
            $userRepository,
            new PlayerRepository(),
            new RegisterRequestRepository(),
            new UserService($userRepository),
            new DiscordRepository(new DiscordClient()),
            new GamePackageRepository(),
            new TrueSkillClient()
        );

        $instance->handle($command);
        $this->assertTrue(true);
    }
}