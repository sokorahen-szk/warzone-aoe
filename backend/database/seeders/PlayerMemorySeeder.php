<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlayerMemoryModel;
use App\Models\PlayerModel;

class PlayerMemorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SeederHelper::truncate('player_memories');

        $playerMap = [];
        for ($i = 1; $i <= 8; $i++) {
            $playerMap[] = $i;
        }

        for ($i = 1; $i <= 1000; $i++) {
            $playerCount = mt_rand(2, 8);
            $dummyPlayerMap = $playerMap;

            for ($x = 1; $x <= $playerCount; $x++) {
                $playerNum = array_splice($dummyPlayerMap, mt_rand(0, count($dummyPlayerMap) - 1), 1);

                PlayerMemoryModel::create([
                    'player_id'         => $playerNum[0],
                    'game_record_id'    => $i,
                    'team'              => $x % 2 == 0 ? 2 : 1,
                    'mu'                => randomFloat(1000, 4000),
                    'sigma'             => randomFloat(10, 100),
                    'rate'              => mt_rand(100, 4000),
                ]);
            }
        }
    }
}

function randomFloat($min = 0, $max = 1)
{
    return $min + mt_rand() / mt_getrandmax() * ($max - $min);
}
