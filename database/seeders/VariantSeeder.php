<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;


class VariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        DB::table('variants')->insert([
            [
                'id_product' => 1,
                'id_attribute_color' => 1,
                'id_attribute_size' => 3,
                'import_price' => 1000000,
                'list_price' => 2000000,
                'selling_price' => 1599000,
                'image_color' => 'https://huythanhjewelry.vn/storage/photos/shares/01upload/1716344802/nc4318-2_1716438677.png',
                'quantity' => 10,
                'is_show' => 0,
            ],
            [
                'id_product' => 1,
                'id_attribute_color' => 1,
                'id_attribute_size' => 2,
                'import_price' => 1000000,
                'list_price' => 2000000,
                'selling_price' => 1599000,
                'image_color' => 'https://huythanhjewelry.vn/storage/photos/shares/01upload/1716344802/nc4318-2_1716438677.png',
                'quantity' => 10,
                'is_show' => 0,
            ],
            [
                'id_product' => 2,
                'id_attribute_color' => 1,
                'id_attribute_size' => 3,
                'import_price' => 2000000,
                'list_price' => 3000000,
                'selling_price' => 1999000,
                'image_color' => 'https://huythanhjewelry.vn/storage/photos/shares/01upload/1717212823/nc852kc-vv-1_1727491436.png',
                'quantity' => 10,
                'is_show' => 0,
            ],
            [
                'id_product' => 3,
                'id_attribute_color' => 1,
                'id_attribute_size' => 2,
                'import_price' => 1500000,
                'list_price' => 2000000,
                'selling_price' => 1799000,
                'image_color' => 'https://huythanhjewelry.vn/storage/photos/shares/01upload/1716344805/nc7967_1716438373.png',
                'quantity' => 10,
                'is_show' => 0,
            ],
            [
                'id_product' => 3,
                'id_attribute_color' => 1,
                'id_attribute_size' => 3,
                'import_price' => 1600000,
                'list_price' => 2000000,
                'selling_price' => 1899000,
                'image_color' => 'https://huythanhjewelry.vn/storage/photos/shares/01upload/1716344805/nc7967_1716438373.png',
                'quantity' => 10,
                'is_show' => 0,
            ],
            [
                'id_product' => 4,
                'id_attribute_color' => 1,
                'id_attribute_size' => 2,
                'import_price' => 1600000,
                'list_price' => 3000000,
                'selling_price' => 1999000,
                'image_color' => 'https://huythanhjewelry.vn/storage/photos/shares/01upload/1716344736/nc4688_1716450597.png',
                'quantity' => 10,
                'is_show' => 0,
            ], [
                'id_product' => 5,
                'id_attribute_color' => 1,
                'id_attribute_size' => 1,
                'import_price' => 1600000,
                'list_price' => 3000000,
                'selling_price' => 1999000,
                'image_color' => 'https://huythanhjewelry.vn/storage/photos/shares/01upload/1713754546/dcptb3663_1715662062.png',
                'quantity' => 10,
                'is_show' => 0,
            ],
        ]);
    }
}
