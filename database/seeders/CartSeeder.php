<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;


class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create();
        for($i=0;$i<5;$i++){
            DB::table('cart')->insert([
            'id_variant'=>rand(1,20),
            'id_user'=>rand(1,10),
            'quantity'=>rand(1,100),
            ]);
        }
    }
}
