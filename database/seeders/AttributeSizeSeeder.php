<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;


class AttributeSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        DB::table('attribute_size')->insert([
            ['name' => 'Over Size'],
            ['name' => '1.5'],
            ['name' => '1.6'],
            ['name' => '1.7'],
            ['name' => '1.8'],
            ['name' => '1.9'],
            ['name' => '2.0'],

        ]);
    }
}
