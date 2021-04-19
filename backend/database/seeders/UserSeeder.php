<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\UserModel;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!SeederHelper::truncate('users')) {
            return;
        }

        // テストアカウント
        UserModel::create([
            'player_id'         => 1,
            'role_id'           => 1,
            'name'              => 'titan',
            'steam_id'          => "4242424242424242",
            'twitter_id'        => "sokorahen-szk",
            'password'          => bcrypt('password'),
        ]);
    }
}
