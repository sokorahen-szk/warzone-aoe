<?php declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Discord;
use Tests\TestCase;
use Package\Infrastructure\Discord\DiscordClient;
use Carbon\Carbon;
use Exception;

class DiscordClientTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_send_message_on_template_from_register_notification_template()
    {
        $client = new DiscordClient();

        $result = $client->sendMessageOnTemplate(
            env('DISCORD_REGISTER_NOTIFICATION_WEBHOOK'),
            'register_notification_template',
            [
                'datetime'      => Carbon::now()->toDatetimeString(),
                'userName'      => 'user名',
                'playerName'    => 'player名',
                'packages'      => 'AoE2HD, AoE2DE',
            ]
        );

        $this->assertTrue($result);
    }

    public function test_invalid_template_name()
    {
        try {
            $client = new DiscordClient();

            $client->sendMessageOnTemplate(
                env('DISCORD_REGISTER_NOTIFICATION_WEBHOOK'),
                'template',
                []
            );

        } catch (Exception $e) {
            $this->assertSame('正しいテンプレート名ではありません。', $e->getMessage());
        }
    }
}