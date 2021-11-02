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
        $this->markTestSkipped('skip');

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
        $this->markTestSkipped('skip');

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

    public function test_send_message_embeds()
    {
        $client = new DiscordClient();

        $packageName = 'AoE2DE';
        $mapName = 'アラビア';
        $playerVS = '4v4';
        $title = sprintf('%s　%s　%s', $packageName, $mapName, $playerVS);
        $gameStartDatetime = '2021-11-02 23:00:00';
        $team1 = "1️⃣　ちぃたん (1000)\n2️⃣　なぎさ(2000)\n3️⃣　ほげほげ (1000)\n4️⃣　ふがふが(1000)";
        $team2 = "1️⃣　ばーばー(1000)\n2️⃣　とーとー(3000)\n3️⃣　てすてすー(1000)\n4️⃣　蝶々(1000)";
        $team1RateSum = 5000;
        $team2RateSum = 6000;

        $client->sendMessageEmbeds(
            env('DISCORD_REGISTER_NOTIFICATION_WEBHOOK'),
            [
                'content'   => '',
                'embeds'    => [
                    [
                        'title' => $title,
                        'description' => 'ゲーム開始',
                        'color' => 0x94c529,
                        'footer' => [
                            'text' => "ゲーム開始：$gameStartDatetime",
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