<?php

namespace App\Repositories\GooglePlaceIds;

use App\Http\Models\GooglePlaceId;

class GooglePlaceIdRepository
{
    protected $table = 'google_place_ids';

    /**
     * Store to google_place_ids table
     *
     * @param array $value
     * @return void
     */
    public function store(array $value): void
    {
        GooglePlaceId::firstOrCreate(
            [
                'place_id' => $value['place_id'],
            ],
            [
                'place_id' => $value['place_id'],
                'name' => $value['name'],
                'icon' => $value['icon'],
                'rating' => $value['rating'],
                'photo' => $value['photo'],
                'vicinity' => $value['vicinity'],
                'user_ratings_total' => $value['user_ratings_total'],
                'price_level' => $value['price_level'],
                'lat' => $value['lat'],
                'lng' => $value['lng'],
                'rating_star' => $value['rating_star']
            ]
        );
    }
}
