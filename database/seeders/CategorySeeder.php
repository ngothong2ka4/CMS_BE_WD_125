<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker= Faker::create();
        DB::table('categories')->insert([
            ['name'=>'Nhẫn'],
            ['name'=>'Vòng cổ'],
            ['name'=>'Lắc tay'],
            ['name'=>'Lắc chân'],


        ]);

    }
}
