<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create();
        DB::table('materials')->insert([
            ['name'=>'Vàng'],
            ['name'=>'Bạc'],
            ['name'=>'Mạ vàng'],

        ]);
    }
}
