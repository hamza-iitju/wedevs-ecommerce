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
        // \App\Models\Admin::factory(10)->create();
        $this->call([
            AdminTableSeeder::class,
            CustomerTableSeeder::class,
            ProductTableSeeder::class
        ]);
    }
}