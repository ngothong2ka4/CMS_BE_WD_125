<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 0; $i < 20; $i++) {
            for ($j = 0; $j < 5; $j++) {
                DB::table('product_images')->insert([
                    'id_product' => $i,
                    'id_attribute_color' => rand(1,6),
                    'link_image' => $faker->imageUrl(),
                ]);
            }
        }
    }
}
