<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 0; $i < 20; $i++) {
            DB::table('products')->insert([
                'id_category' => rand(1, 4),
                'id_materials' => rand(1, 3),
                'id_stones' => rand(1, 3),
                'name' => $faker->text(25),
                'description' => $faker->text(),
                'thumbnail' => $faker->imageUrl(),
                'sold' => rand(0, 1000),
            ]);
        }
    }
}
