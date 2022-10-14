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

        $date = Carbon::today()->subMonth(4);
        for ($i = 1; $i <= 1000; $i++) {
            $status = mt_rand(2, 4);
            GameRecordModel::create([
                'game_package_id'       => 1,
                'user_id'               => 1,
                'rule_id'               => mt_rand(1, 2),
                'map_id'                => mt_rand(1, 2),
                'winning_team'          => mt_rand(1, 2),
                'victory_prediction'    => mt_rand(0, 100),
                'status'                => $status,
                'started_at'            => $date->format('Y-m-d H:i:s'),
                'finished_at'           => $status >= 2 ? $date->addMinute(mt_rand(30, 60))->format('Y-m-d H:i:s') : null,
            ]);

            $date->addDay(1);
        }
    }
}
