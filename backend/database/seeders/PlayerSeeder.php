<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlayerModel;

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
    }
}
