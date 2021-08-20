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
            $status = mt_rand(1, 3);
            RegisterRequestModel::create([
                'user_id'               => $i,
                'created_by_user_id'    => $status === 1 ? null : mt_rand(1, 5),
                'status'                => $status,
                'remarks'               => $status === 1 ? null : $faker->text,
            ]);
        }
    }
}
