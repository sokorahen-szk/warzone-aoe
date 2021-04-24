<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlayerModel;
use Faker\Factory as FakerFactory;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!SeederHelper::truncate('players')) {
            return;
        }

        // テストアカウント
        PlayerModel::create([
            'name'              => 'titan',
            'mu'                => 3600.01,
            'sigma'             => 3600.01,
            'rate'              => 2000,
            'min_rate'          => 1200,
            'max_rate'          => 2500,
            'win'               => 20,
            'defeat'            => 30,
            'games'             => 55,
            'joined_at'         => '2019-02-10',
            'last_game_at'      => '2020-10-22',
            'enabled'           => true,
        ]);

        $faker = FakerFactory::create();

        $enabled = [true, false];

        // ここからダミーデータ
        for ($i = 1; $i <= 100; $i++) {
            $win = mt_rand(1, 100);
            $defeat = mt_rand(1, 100);
            $games = $win + $defeat + mt_rand(0, 10);
            PlayerModel::create([
                'name'              => strtolower($faker->firstNameFemale) . $i,
                'mu'                => 3600.01,
                'sigma'             => 3600.01,
                'rate'              => mt_rand(600, 2000),
                'min_rate'          => mt_rand(100, 500),
                'max_rate'          => mt_rand(2000, 3000),
                'win'               => $win,
                'defeat'            => $defeat,
                'games'             => $games,
                'joined_at'         => '2019-02-10',
                'last_game_at'      => '2020-10-22',
                'enabled'           => $enabled[mt_rand(0, 1)],
            ]);
        }
    }
}
