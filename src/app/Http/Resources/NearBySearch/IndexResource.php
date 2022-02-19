<?php

namespace App\Http\Resources\NearBySearch;

use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $resource = $this->resource;
        return [
            'name' => isset($resource['name']) ? "{$resource['name']}" : '',
            'icon' => isset($resource['icon']) ? "{$resource['icon']}" : '',
            'rating' => isset($resource['rating']) ? "{$resource['rating']}" : '',
            'photo' => isset($resource['photo']) ? "{$resource['photo']}" : '',
            'vicinity' => isset($resource['vicinity']) ? "{$resource['vicinity']}" : '',
            'userRatingsTotal' => isset($resource['user_ratings_total']) ? (int) "{$resource['user_ratings_total']}" : 0,
            'priceLevel' => isset($resource['price_level']) ? (int) "{$resource['price_level']}" : null,
            'lat' => (float) $resource['lat'],
            'lng' => (float) $resource['lng'],
            'placeId' => $resource['place_id'],
            'ratingStar' => isset($resource['rating_star']) ? "{$resource['rating_star']}" : '',
        ];
    }
}
