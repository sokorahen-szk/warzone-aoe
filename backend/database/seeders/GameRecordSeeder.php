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
            GameRecordModel::create([
                'game_package_id' => 2,
                'user_id'         => 1,
                'winning_team'    => mt_rand(1, 2),
                //'status'          => mt_rand(1, 4),
                'status'          => 4,
                'started_at'      => $date->format('Y-m-d H:i:s'),
                'finished_at'     => $date->addMinute(mt_rand(30, 60))->format('Y-m-d H:i:s'),
            ]);

            $date->addDay(1);
        }
    }
}