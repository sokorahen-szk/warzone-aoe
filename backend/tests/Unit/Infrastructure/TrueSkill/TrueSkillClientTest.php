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

    public function test_default_skill()
    {
        $client = new TrueSkillClient();
        $res = $client->defaultSkill();
        $this->assertCount(3, $res);
        $this->assertEquals(2500, $res['mu']);
        $this->assertEquals(833.33333333333, $res['sigma']);
        $this->assertEquals(0, $res['rating_exposure']);
    }

    public function test_team_division_pattern()
    {
        $client = new TrueSkillClient();

        $expectedRes = (object) [
            'quality'   => 0.2713578508430548,
            'team1'     => [
                (object) [
                    'id'        => 1,
                    'name'      => 'titan',
                    'mu'        => 3000.5,
                    'sigma'     => 150,
                ]
            ],
            'team2'     => [
                (object) [
                    'id'        => 2,
                    'name'      => 'nagisa',
                    'mu'        => 2000,
                    'sigma'     => 200,
                ],
            ],
            'sum_mu1'   =>  3000.5,
            'sum_mu2'   =>  2000,
        ];

        $data = [
            'players' => [
                ['id' => 1, 'name' => 'titan', 'mu' => 3000.5, 'sigma' => 150],
                ['id' => 2, 'name' => 'nagisa', 'mu' => 2000, 'sigma' => 200],
            ],
        ];

        $actualRes = $client->teamDivisionPattern($data)[0];
        $this->assertEquals($expectedRes->quality, $actualRes->quality);
        $this->assertEquals($expectedRes->sum_mu1, $actualRes->sum_mu1);
        $this->assertEquals($expectedRes->sum_mu2, $actualRes->sum_mu2);
        $this->assertEquals($expectedRes->team1[0]->id, $actualRes->team1[0]->id);
        $this->assertEquals($expectedRes->team1[0]->name, $actualRes->team1[0]->name);
        $this->assertEquals($expectedRes->team1[0]->mu, $actualRes->team1[0]->mu);
        $this->assertEquals($expectedRes->team1[0]->sigma, $actualRes->team1[0]->sigma);
        $this->assertEquals($expectedRes->team2[0]->id, $actualRes->team2[0]->id);
        $this->assertEquals($expectedRes->team2[0]->name, $actualRes->team2[0]->name);
        $this->assertEquals($expectedRes->team2[0]->mu, $actualRes->team2[0]->mu);
        $this->assertEquals($expectedRes->team2[0]->sigma, $actualRes->team2[0]->sigma);
    }
}
