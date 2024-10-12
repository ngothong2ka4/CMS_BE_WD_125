<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        DB::table('product_images')->insert([
            [
                'id_product' => 1,
                'link_image' => ' https://huythanhjewelry.vn/storage/photos/shares/01upload/1716344803/nc4319-2_1716438595.png',
            ],
            [
                'id_product' => 1,
                'link_image' => 'https://huythanhjewelry.vn/storage/photos/shares/01upload/1716344804/nc43110-2_1716438654.png',
            ],
            [
                'id_product' => 1,
                'link_image' => 'https://huythanhjewelry.vn/storage/photos/shares/01upload/1716344804/nc43110-2_1716438654.png',
            ],
            [
                'id_product' => 2,
                'link_image' => ' https://huythanhjewelry.vn/storage/photos/shares/01upload/1717212823/nc852kc-vv-1_1727491436.png',
            ],
            [
                'id_product' => 2,
                'link_image' => 'https://huythanhjewelry.vn/storage/photos/shares/01upload/1716344677/nc852kcw-vv-1_1727491573.png',
            ],
            [
                'id_product' => 2,
                'link_image' => 'https://huythanhjewelry.vn/storage/photos/shares/01upload/1717212823/nc852kc-vv-1_1727491436.png',
            ],
            [
                'id_product' => 3,
                'link_image' => ' https://huythanhjewelry.vn/storage/photos/shares/01upload/1716344807/nc796kcw6_1716438335.png',
            ],
            [
                'id_product' => 3,
                'link_image' => 'https://huythanhjewelry.vn/storage/photos/shares/01upload/1723542896/nc796m6_1723543779.png',
            ],
            [
                'id_product' => 3,
                'link_image' => 'https://huythanhjewelry.vn/storage/photos/shares/01upload/1716344805/nc7967_1716438373.png',
            ],
            [
                'id_product' => 4,
                'link_image' => 'https://huythanhjewelry.vn/storage/photos/shares/01upload/1713754546/dcptb3663_1715662062.png',
            ],
            [
                'id_product' => 4,
                'link_image' => 'https://huythanhjewelry.vn/storage/photos/shares/01upload/1713754546/dcptb3661_1716263545.jpg',
            ],
            [
                'id_product' => 4,
                'link_image' => 'https://huythanhjewelry.vn/storage/photos/shares/01upload/1713754546/dcptb3662_1715662186.jpg',
            ],
        ]);
    }
}
