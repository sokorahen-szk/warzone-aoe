<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\RoleModel;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SeederHelper::truncate('roles');

        RoleModel::create([
            'name'      => 'owner',
            'level'     => 100,
        ]);
        RoleModel::create([
            'name'      => 'administrator',
            'level'     => 50,
        ]);
        RoleModel::create([
            'name'      => 'moderator',
            'level'     => 5,
        ]);
        RoleModel::create([
            'name'      => 'user',
            'level'     => 1,
        ]);
    }
}
