<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class AttributeColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker= Faker::create();
        DB::table('attribute_color')->insert([
            ['name'=>'xanh dương'],
            ['name'=>'đỏ'],
            ['name'=>'vàng'],
            ['name'=>'tím'],
            ['name'=>'hồng'],
            ['name'=>'xanh lam'],

        ]);
    }
}
