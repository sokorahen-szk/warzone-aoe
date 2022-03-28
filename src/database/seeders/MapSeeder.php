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
        SeederHelper::truncate('maps');

        //
        // imageのpathは
        // /storage/maps/<game_paclage_id>/<image name>
        $data = [
            (object) [
                'game_package_id'   => 1,
                'name'              => 'アラビア',
                'image'             => '/storage/maps/1/arabia.jpg',
            ],
            (object) [
                'game_package_id'   => 1,
                'name'              => 'その他',
                'image'             => null,
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
