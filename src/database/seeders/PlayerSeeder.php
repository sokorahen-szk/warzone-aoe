<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlayerModel;
use Faker\Factory as FakerFactory;
use Carbon\Carbon;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SeederHelper::truncate('players');

        $gamePackages = [
            '1', '2', '1,2', '1,2,3', null,
        ];

        // (オーナー）テストアカウント
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
            'games'             => mt_rand(-10, 10),
            'game_packages'     => '1',
            'joined_at'         => '2019-02-10 00:00:00',
            'last_game_at'      => '2020-10-22 00:00:00',
            'enabled'           => true,
        ]);

        // (管理者）テストアカウント
        PlayerModel::create([
            'name'              => 'titan2',
            'mu'                => 3600.01,
            'sigma'             => 3600.01,
            'rate'              => 2000,
            'min_rate'          => 1200,
            'max_rate'          => 2500,
            'win'               => 20,
            'defeat'            => 30,
            'games'             => 55,
            'games'             => mt_rand(-10, 10),
            'game_packages'     => '1,2',
            'joined_at'         => '2019-02-10 00:00:00',
            'last_game_at'      => '2020-10-22 00:00:00',
            'enabled'           => true,
        ]);

        // (編集者）テストアカウント
        PlayerModel::create([
            'name'              => 'titan3',
            'mu'                => 3600.01,
            'sigma'             => 3600.01,
            'rate'              => 2000,
            'min_rate'          => 1200,
            'max_rate'          => 2500,
            'win'               => 20,
            'defeat'            => 30,
            'games'             => 55,
            'games'             => mt_rand(-10, 10),
            'game_packages'     => '1,2,3',
            'joined_at'         => '2019-02-10 00:00:00',
            'last_game_at'      => '2020-10-22 00:00:00',
            'enabled'           => true,
        ]);

        // (一般ユーザ）テストアカウント
        PlayerModel::create([
            'name'              => 'titan4',
            'mu'                => 3600.01,
            'sigma'             => 3600.01,
            'rate'              => 2000,
            'min_rate'          => 1200,
            'max_rate'          => 2500,
            'win'               => 20,
            'defeat'            => 30,
            'games'             => 55,
            'games'             => mt_rand(-10, 10),
            'game_packages'     => '1,2,3',
            'joined_at'         => '2019-02-10 00:00:00',
            'last_game_at'      => '2020-10-22 00:00:00',
            'enabled'           => true,
        ]);

        $faker = FakerFactory::create();

        $enabled = [true, false];

        // ここからダミーデータ
        for ($i = 1; $i < 10; $i++) {
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
                'games'             => mt_rand(-10, 10),
                'game_packages'     => $gamePackages[mt_rand(0, 3)],
                'joined_at'         => Carbon::now(),
                'last_game_at'      => (bool) mt_rand(0, 1) ? Carbon::now() : null,
                'enabled'           => $enabled[mt_rand(0, 1)],
            ]);
        }
    }
}
