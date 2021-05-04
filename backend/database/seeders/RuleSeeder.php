<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\RuleModel;

class RuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SeederHelper::truncate('rules');

        $data = [
            (object) [
                'game_package_id'   => 1,
                'name'              => 'ESUDAルール',
                'description'       => 'ESUDAルール',
            ],
            (object) [
                'game_package_id'   => 2,
                'name'              => 'ESUDAルール',
                'description'       => 'ESUDAルール',
            ],
        ];

        foreach ($data as $d) {
            RuleModel::create([
                'game_package_id'   => $d->game_package_id,
                'name'              => $d->name,
                'description'       => $d->description,
            ]);
        }
    }
}
