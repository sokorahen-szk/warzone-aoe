<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlayerModel;
use App\Models\UserModel;
use Faker\Factory as FakerFactory;
use Carbon\Carbon;
use App\Models\GamePackageModel;

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
        $gamePackages = GamePackageModel::get();

        // (オーナー）テストアカウント
        PlayerModel::create([
            'user_id'           => 1,
            'game_package_id'   => $gamePackages[0]->id,
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
            'last_game_at'      => '2020-10-22 00:00:00',
            'enabled'           => true,
        ]);

        // (管理者）テストアカウント
        PlayerModel::create([
            'user_id'           => 2,
            'game_package_id'   => $gamePackages[mt_rand(0, $gamePackages->count() - 1)]->id,
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
            'last_game_at'      => '2020-10-22 00:00:00',
            'enabled'           => true,
        ]);

        // (編集者）テストアカウント
        PlayerModel::create([
            'user_id'           => 3,
            'game_package_id'   => $gamePackages[mt_rand(0, $gamePackages->count() - 1)]->id,
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
            'last_game_at'      => '2020-10-22 00:00:00',
            'enabled'           => true,
        ]);

        // (一般ユーザ）テストアカウント
        PlayerModel::create([
            'user_id'           => 4,
            'game_package_id'   => $gamePackages[mt_rand(0, $gamePackages->count() - 1)]->id,
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
            'last_game_at'      => '2020-10-22 00:00:00',
            'enabled'           => true,
        ]);

        $enabled = [true, false];
        $users = UserModel::get();

        // ここからダミーデータ
        for ($i = 1; $i <= 2; $i++) {
            foreach ($users as $user) {
                if ($user->id <= 4) {
                    continue;
                }

                $win = mt_rand(1, 100);
                $defeat = mt_rand(1, 100);
                $games = $win + $defeat + mt_rand(0, 10);
                PlayerModel::create([
                    'user_id'           => $user->id,
                    'game_package_id'   => $i,
                    'name'              => $user->name,
                    'mu'                => 3600.01,
                    'sigma'             => 3600.01,
                    'rate'              => mt_rand(600, 2000),
                    'min_rate'          => mt_rand(100, 500),
                    'max_rate'          => mt_rand(2000, 3000),
                    'win'               => $win,
                    'defeat'            => $defeat,
                    'games'             => $games,
                    'games'             => mt_rand(-10, 10),
                    'last_game_at'      => (bool) mt_rand(0, 1) ? Carbon::now() : null,
                    'enabled'           => $enabled[mt_rand(0, 1)],
                ]);
            }
        }
    }
}
