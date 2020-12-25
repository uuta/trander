<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GoogleplaceIdsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            [
                "name" => "健康市川温泉クリーンスパ市川",
                "icon" => "https://maps.gstatic.com/mapfiles/place_api/icons/v1/png_71/generic_business-71.png",
                "rating" => "3.7",
                "photo" => "ATtYBwKlOwh6nuNaJIMWGac1n5yb7n6Ss93MQJF4ngbOXjz2FSX4h_-xmz5uvlnAnZojw01-Rb19KQDQOBlbYIvj13g1sEVuiIXomYi4g7d0Yj3ZPVqRrtTA3gLly99E2GdliKNsk0-VJlbWaRoSRovPGLXx9TcyA8hejLOf5xWAOonT7vL7",
                "vicinity" => "市川市上妙典１５５４",
                "lat" => "35.686291",
                "lng" => "139.943663",
                "user_ratings_total" => "568",
                "price_level" => null,
                "place_id" => "ChIJ143gD6mAGGAR07Sm5yNzFlw",
                "rating_star" => "3_5",
            ],
            [
                "name" => "東京天然温泉古代の湯",
                "icon" => "https://maps.gstatic.com/mapfiles/place_api/icons/v1/png_71/geocode-71.png",
                "rating" => "3.5",
                "photo" => "ATtYBwLHoRDpviYCc-t6TsXgZ5dpwhgVqX4BJqQGJemSBkyIKW-BN6mAm0fy-ZOkdH68wGp-cW5a8XlLuMmH2G5tStffEGo4ML9jkVlP424yPvgI6wpNwuDebFba6PAqMfkJukBCUnDxfb7XPtQoM8HAyzEwkeo8Q7gDWM-WglPn_2T2CXPY",
                "vicinity" => "葛飾区奥戸４丁目２−１",
                "lat" => "35.7289238",
                "lng" => "139.8627777",
                "user_ratings_total" => "454",
                "price_level" => 3,
                "place_id" => "ChIJrxB0hPyFGGARiBrTkA2Xd3I",
                "rating_star" => "3_5",
            ],
            [
                "name" => "あけぼの湯",
                "icon" => "https://maps.gstatic.com/mapfiles/place_api/icons/v1/png_71/generic_business-71.png",
                "rating" => "4.1",
                "photo" => "ATtYBwKrWT_Jrg-vwlRW9SPrSD7qC6CDOQeD7eNQ9yzehtvitAhmcY3Bd9C5lS-qOpILMccjK3i8u-NJC7EkU-4sYKwUUXzdnUn_fK_eNowA-nsv99qx86SRpUUECtHTd97ADXsFXgJpiSSXQ_62eNc7u7WZRELQTEaN4gq0u1vj8CBgrrgx",
                "vicinity" => "江戸川区船堀３丁目１２−１１",
                "lat" => "35.6808429",
                "lng" => "139.8638889",
                "user_ratings_total" => "295",
                "price_level" => null,
                "place_id" => "ChIJP9EIOdCHGGARuPZVTZChizA",
                "rating_star" => "4",
            ],
        ];
        DB::table('google_place_ids')->insert($values);
    }
}
