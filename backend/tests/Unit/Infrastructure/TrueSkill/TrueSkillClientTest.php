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
        $this->markTestSkipped();
        $client = new TrueSkillClient();
        $this->assertInstanceOf(TrueSkillClient::class, $client);
    }

    public function test_get_token()
    {
        $this->markTestSkipped();
        $client = new TrueSkillClient();
        $this->assertNotNull($client->token());
    }

    public function test_default_skill()
    {
        $this->markTestSkipped();
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

        $actualRes = $client->teamDivisionPattern($data);
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

    public function test_calc_skill()
    {
        $this->markTestSkipped();
        $client = new TrueSkillClient();

        $expectedRes = (object) [
            'teams' => [
                (object) [
                    'id' => 1,
                    'mu' => 3004.907679992,
                    'sigma' => 149.35588972028,
                    'rating_exposure' => 2556.8400108312,
                ],
                (object) [
                    'id' => 2,
                    'mu' => 1992.1746727527,
                    'sigma' => 198.09794308279,
                    'rating_exposure' => 1397.8808435043,
                ],
            ],
            'winning_team' => 1,
            'quality' => 0.27135785084305,
            'win_probability' => 0.94097935551412,
        ];

        $data = [
            'teams' => [
                // team1
                [
                    ['id' => 1, 'name' => 'titan', 'mu' => 3000.5, 'sigma' => 150],
                ],
                // team2
                [
                    ['id' => 2, 'name' => 'nagisa', 'mu' => 2000, 'sigma' => 200],
                ],
            ],
            'winning_team' => 1,
        ];

        $actualRes = $client->calcSkill($data);

        $this->assertEquals($expectedRes->winning_team, $actualRes['winning_team']);
        $this->assertEquals($expectedRes->quality, $actualRes['quality']);
        $this->assertEquals($expectedRes->win_probability, $actualRes['win_probability']);
        $this->assertEquals($expectedRes->teams[0]->id, $actualRes['teams'][0][0]->id);
        $this->assertEquals($expectedRes->teams[0]->mu, $actualRes['teams'][0][0]->mu);
        $this->assertEquals($expectedRes->teams[0]->sigma, $actualRes['teams'][0][0]->sigma);
        $this->assertEquals($expectedRes->teams[0]->rating_exposure, $actualRes['teams'][0][0]->rating_exposure);

        $this->assertEquals($expectedRes->teams[1]->id, $actualRes['teams'][1][0]->id);
        $this->assertEquals($expectedRes->teams[1]->mu, $actualRes['teams'][1][0]->mu);
        $this->assertEquals($expectedRes->teams[1]->sigma, $actualRes['teams'][1][0]->sigma);
        $this->assertEquals($expectedRes->teams[1]->rating_exposure, $actualRes['teams'][1][0]->rating_exposure);
    }
}
