<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class StoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        DB::table('stones')->insert([
            ['name'=>'Đá Thạch Anh'],
            ['name'=>'Đá Ngọc lam'],
            ['name'=>'Đá Moonstone'],

        ]);
    }
}
