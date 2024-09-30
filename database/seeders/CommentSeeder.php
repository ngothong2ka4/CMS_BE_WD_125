<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create();
        for ($i = 0; $i < 20; $i++) {
            DB::table('comments')->insert([
                'id_product'=>rand(1,20),
                'id_user'=>rand(1,5),
                'content'=>$faker->text(),
                'posting_date'=>$faker->date(),
                'status'=>rand(0,1),
            ]);
        }
    }
}
