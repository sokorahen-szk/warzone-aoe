<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(RoleSeeder::class);
        $this->call(GamePackageSeeder::class);
        $this->call(RuleSeeder::class);
        $this->call(MapSeeder::class);
        $this->call(UserSeeder::class);
    }
}
