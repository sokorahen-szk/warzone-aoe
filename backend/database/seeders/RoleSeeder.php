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
        if (!SeederHelper::truncate('roles')) {
            return;
        }
        RoleModel::create([
            'name'      => '管理者',
            'level'     => 99,
        ]);
        RoleModel::create([
            'name'      => '編集者',
            'level'     => 5,
        ]);
        RoleModel::create([
            'name'      => '一般ユーザ',
            'level'     => 1,
        ]);
    }
}
