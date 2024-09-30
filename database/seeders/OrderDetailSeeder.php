<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create();
        DB::table('order_detail')->insert([
            'id_oder' => rand(1,10),
            'id_variant' => rand(1,20),
            'import_price' => $faker->randomFloat(2, 100, 500),
            'list_price' => $faker->randomFloat(2, 500, 1000),
            'selling_price' => $faker->randomFloat(2, 400, 900),
            'product_name' => $faker->text(50),
            'product_image' => $faker->imageUrl(),
            'quantity' => rand(1, 1000),
        ]);

    }
}
