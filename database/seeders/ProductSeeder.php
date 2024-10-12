<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        DB::table('products')->insert([
            [
                'id_category' => 1,
                'id_materials' => 1,
                'id_stones' => 1,
                'name' => 'Nhẫn cưới Vàng 14K Kim cương tự nhiên',
                'thumbnail' => 'https://huythanhjewelry.vn/storage/photos/shares/01upload/1716344802/nc4318-2_1716438677.png',

            ],
            [
                'id_category' => 1,
                'id_materials' => 1,
                'id_stones' => 1,
                'name' => 'Nhẫn cưới Vàng 14K Kim cương thiên nhiên',
                'thumbnail' => 'https://huythanhjewelry.vn/storage/photos/shares/01upload/1717212823/nc852kc-vv-1_1727491436.png',

            ],
            [
                'id_category' => 1,
                'id_materials' => 1,
                'id_stones' => 1,
                'name' => 'Nhẫn cưới Vàng 18K& Platinum 950 Kim cương tự nhiên',
                'thumbnail' => 'https://huythanhjewelry.vn/storage/photos/shares/01upload/1716344805/nc7967_1716438373.png',

            ],
            [
                'id_category' => 2,
                'id_materials' => 1,
                'id_stones' => 3,
                'name' => 'Dây chuyền Vàng 14K đá CZ',
                'thumbnail' => 'https://huythanhjewelry.vn/storage/photos/shares/01upload/1713754546/dcptb3663_1715662062.png',

            ],
        ]);
    }
}
