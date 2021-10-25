<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\UserModel;
use Faker\Factory as FakerFactory;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SeederHelper::truncate('users');

        // オーナー
        UserModel::create([
            'player_id'         => 1,
            'role_id'           => 1,
            'name'              => 'titan',
            'steam_id'          => "4242424242424242",
            'twitter_id'        => "sokorahen-szk",
            'status'            => 2,
            'avator_image'      => '/storage/profile/1.jpeg',
            'password'          => bcrypt('password'),
        ]);

        // 管理者
        UserModel::create([
            'player_id'         => 2,
            'role_id'           => 2,
            'name'              => 'titan2',
            'steam_id'          => "4242424242424242",
            'twitter_id'        => "sokorahen-szk",
            'status'            => 2,
            'avator_image'      => '/storage/profile/1.jpeg',
            'password'          => bcrypt('password'),
        ]);

        // 編集者
        UserModel::create([
            'player_id'         => 3,
            'role_id'           => 3,
            'name'              => 'titan3',
            'steam_id'          => "4242424242424242",
            'twitter_id'        => "sokorahen-szk",
            'status'            => 2,
            'avator_image'      => '/storage/profile/1.jpeg',
            'password'          => bcrypt('password'),
        ]);


        // 一般ユーザ
        UserModel::create([
            'player_id'         => 4,
            'role_id'           => 4,
            'name'              => 'titan4',
            'steam_id'          => "4242424242424242",
            'twitter_id'        => "sokorahen-szk",
            'status'            => 2,
            'avator_image'      => '/storage/profile/1.jpeg',
            'password'          => bcrypt('password'),
        ]);

        $faker = FakerFactory::create();
        $index = UserModel::count();
        // ここからダミーデータ
        for ($i = 1; $i < 10; $i++) {
            UserModel::create([
                'player_id'         => $index + $i,
                'role_id'           => mt_rand(1, 3),
                'name'              => strtolower($faker->firstNameFemale) . $i,
                'status'            => mt_rand(1, 4),
                'password'          => bcrypt('password'),
            ]);
        }
    }
}
