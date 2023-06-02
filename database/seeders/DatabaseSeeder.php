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
        \App\Models\User::factory(10)->create();
        // \App\Models\Kendaraan::factory(10)->create();
        \App\Models\Mobil::factory(10)->create();
        \App\Models\Motor::factory(10)->create();
    }
}
