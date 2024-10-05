<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;


class VariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 0; $i < 20; $i++) {
            DB::table('variants')->insert([
                'id_product'=> rand(1, 20),
                'id_attribute_color' => rand(1, 6),
                'id_attribute_size' => rand(1, 6),
                'import_price' => $faker->randomFloat(2, 100, 500),
                'list_price' => $faker->randomFloat(2, 500, 1000),
                'selling_price' => $faker->randomFloat(2, 400, 900),
                'image_color'=>$faker->imageUrl() ,
                'quantity' => rand(1, 1000),
                'is_show' => $faker->boolean(),

            ]);
        }
    }
}
