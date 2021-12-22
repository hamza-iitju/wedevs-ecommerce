<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;


class ProductTableSeeder extends Seeder
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
            DB::table('products')->insert([
                'name' => $faker->city,
                'slug' => $faker->unique()->slug,
                'images' => '["'.$index.'.png"]',
                'price' => $faker->numberBetween($min = 500, $max = 8000),
                'qty' => $faker->numberBetween($min = 10, $max = 100),
                'description'=> $faker->paragraph($nb =8)
            ]);
        }
    }
}
