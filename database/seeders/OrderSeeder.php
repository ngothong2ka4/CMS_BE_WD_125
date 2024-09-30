<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        DB::table('order')->insert([
            'id_user' => rand(1,10),
            'recipient_name' => $faker->text(),
            'email' => $faker->email,
            'phone_number' => $faker->phoneNumber(),
            'recipient_address' => $faker->address(),
            'order_date' => $faker->date(),
            'total_payment' => $faker->randomFloat(2,100,1000),
            'payment_role' => $faker->randomElement(['Trả tiền khi nhận hàng','Thanh toán bằng ví điện tử / QR','Thanh Toán bằng MoMo']),
            'status_payment' => $faker->randomElement(['Đang chờ xử lý','Đã hoàn thành','Đã hủy']),
            'status' => $faker->randomElement(['Đang chờ xử lý','Đang vận chuyển','Đang chờ giao hàng','Đã hủy']),


        ]);
    }
}
