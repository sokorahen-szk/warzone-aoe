<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\MapModel;

class MapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!SeederHelper::truncate('maps')) {
            return;
        }

        $data = [
            (object) [
                'game_package_id'   => 1,
                'name'              => 'アラビア',
                'image'             => 'map/1/arabia.jpg',
            ],
            (object) [
                'game_package_id'   => 2,
                'name'              => 'アラビア',
                'image'             => 'map/2/arabia.jpg',
            ],
        ];

        foreach ($data as $d) {
            MapModel::create([
                'game_package_id'   => $d->game_package_id,
                'name'              => $d->name,
                'image'             => $d->image,
            ]);
        }

    }
}
