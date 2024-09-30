<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for($i=0;$i<9;$i++){
        DB::table('users')->insert([
            'name' => $faker->text(50),
            'image' => $faker->imageUrl(),
            'email' => $faker->email,
            'email_verified_at' => $faker->dateTime(),
            'password' => $faker->password,
            'address' => $faker->address,
            'role' => rand(0,1),
            'status' => rand(0,1),
        ]);}
    }
}
