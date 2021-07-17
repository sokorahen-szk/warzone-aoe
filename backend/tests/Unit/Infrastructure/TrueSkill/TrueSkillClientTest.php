<?php

namespace Tests\Unit\Infrastructure\TrueSkill;
use Tests\TestCase;
use Package\Infrastructure\TrueSkill\TrueSkillClient;

class TrueSkillClientTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_new_instance()
    {
        $client = new TrueSkillClient();
        $this->assertInstanceOf(TrueSkillClient::class, $client);
    }

    public function test_get_token()
    {
        $client = new TrueSkillClient();
        $this->assertNotNull($client->token());
    }
}
