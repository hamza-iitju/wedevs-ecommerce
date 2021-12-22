<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Provider\nb_NO\MobileNumber;

class CustomerTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 20) as $index)  {
            DB::table('customers')->insert([
                'name' => $faker->name,
                'phone' => '01'.$faker->randomKey([000000000, 999999999]),
                'address' => $faker->address,
                'email' => Str::random(10).'@gmail.com',
                'password' => Hash::make('password'),
                'image' => 'customer.jpg',
            ]);
        }
    }
}
