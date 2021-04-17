<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GamePackageModel;

class GamePackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!SeederHelper::truncate('game_packages')) {
            return;
        }
        GamePackageModel::create([
            'name'          => 'AoE2HD',
            'description'   => 'Age Of Empires 2 Home Edition',
        ]);
        GamePackageModel::create([
            'name'          => 'AoE2DE',
            'description'   => 'Age Of Empires 2 Definitive Edition',
        ]);
    }
}
