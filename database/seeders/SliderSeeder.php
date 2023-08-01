<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sliders')->insert([
            [
                'banner' => '/frontend/images/slider_1.jpg',
                'type' => 'Menswear',
                'title' => 'Men\'s Fashion',
                'starting_price' => '100',
                'btn_url' => 'http://ecommerce.test/',
                'serial' => 1,
                'status' => 1,
            ],
            [
                'banner' => '/frontend/images/slider_4.jpg',
                'type' => 'Women\'s Wear',
                'title' => 'Summer Collection',
                'starting_price' => '250',
                'btn_url' => 'http://ecommerce.test/',
                'serial' => 2,
                'status' => 1,
            ],
            [
                'banner' => '/frontend/images/slider_5.jpg',
                'type' => 'Women\'s Wear',
                'title' => 'Women\'s Fashion',
                'starting_price' => '200',
                'btn_url' => 'http://ecommerce.test/',
                'serial' => 3,
                'status' => 0,
            ],
        ]);
    }
}
