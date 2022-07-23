<?php

namespace App\Http\Resources\Backpacker;

use Illuminate\Http\Resources\Json\JsonResource;

class BackpackerCitiesIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $geo_db_cities = $this[0];
        $near_by_search = $this[1];

        $name = '';
        $name .= array_key_exists('region', $geo_db_cities) ? "{$geo_db_cities['region']} " : '';
        $name .= array_key_exists('name', $geo_db_cities) ? "{$geo_db_cities['name']}" : '';

        return [
            'name' => $name,
            'wiki_data_id' => array_key_exists('wikiDataId', $geo_db_cities) ? "{$geo_db_cities['wikiDataId']}" : '',
            'country_code' => ($geo_db_cities['countryCode']) ? strtolower($geo_db_cities['countryCode']) : '',
            'icon' => $near_by_search['icon'] ?? '',
            'rating' => isset($near_by_search['rating']) ? (float) $near_by_search['rating'] : (float) 0,
            'photo' => $near_by_search['photos'][0]['photo_reference'] ?? '',
            'vicinity' => $near_by_search['vicinity'] ?? '',
            'user_ratings_total' => $near_by_search['user_ratings_total'] ?? 0,
            'price_level' => $near_by_search['price_level'] ?? 0,
            'lat' => (float) round($near_by_search['geometry']['location']['lat'], 7) ?? 0,
            'lng' => (float) round($near_by_search['geometry']['location']['lng'], 7) ?? 0,
            'place_id' => $near_by_search['place_id'] ?? '',
            'rating_star' => $near_by_search['ratingStar'] ?? ''
        ];
    }
}
