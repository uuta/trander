<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GooglePlaceId extends Model
{
    protected $fillable = [
        'place_id',
        'name',
        'icon',
        'rating',
        'photo',
        'vicinity',
        'user_ratings_total',
        'price_level',
        'lat',
        'lng',
        'rating_star'
    ];

    /**
     * Get google place infomation
     *
     * @param string $id
     * @return self
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public static function get_information(string $id)
    {
        return self::where('place_id', $id)
            ->firstOrFail([
                'name',
                'icon',
                'rating',
                'photo',
                'vicinity',
                'user_ratings_total',
                'price_level',
                'lat',
                'lng',
                'rating_star',
            ]);
    }

    /**
     * Insert values
     *
     * @param array $value
     * @return void
     */
    public static function insert_information(array $value) : void
    {
        self::firstOrCreate(
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
