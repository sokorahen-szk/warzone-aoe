<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\RegisterRequestModel;
use Faker\Factory as FakerFactory;

class RegisterRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SeederHelper::truncate('register_requests');
        $faker = FakerFactory::create();

        for ($i = 1; $i <= 10; $i++) {
            RegisterRequestModel::create([
                'player_id' => $i,
                'user_id'   => mt_rand(1, 5),
                'status'    => mt_rand(1, 3),
                'remarks'   => $faker->text,
            ]);
        }
    }
}
