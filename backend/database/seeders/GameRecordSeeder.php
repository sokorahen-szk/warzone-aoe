<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GameRecordModel;
use Carbon\Carbon;

class GameRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SeederHelper::truncate('game_records');

        for ($i = 1; $i <= 100; $i++) {
            GameRecordModel::create([
                'game_package_id' => 2,
                'user_id'         => 1,
                'winning_team'    => mt_rand(1, 2),
                'status'          => mt_rand(1, 4),
                'started_at'      => Carbon::now(),
                'finished_at'     => Carbon::now(),
            ]);
        }
    }
}
