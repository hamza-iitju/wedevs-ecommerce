<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class AdminTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name' => "Md. Ameer Hamza",
            'email' => "hamza.iitju@gmail.com",
            'password' => bcrypt('hamza123')
        ]);
    }
}
