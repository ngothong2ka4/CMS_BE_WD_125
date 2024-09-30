<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class OrderHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        DB::table('order_history')->insert([
            'id_order' => rand(1,10),
            'from_status' => $faker->randomElement(['Đang chờ xử lý', 'Đang vận chuyển', 'Đang chờ giao hàng', 'Đã hủy']),
            'to_status' => $faker->randomElement(['Đang chờ xử lý', 'Đang vận chuyển', 'Đang chờ giao hàng', 'Đã hủy']),
            'note' => $faker->text(),
            'id_user' => rand(1,20),
            'at_date_time' => $faker->dateTime(),
        ]);
    }
}
