<?php

namespace App\Http\Resources\Cities;

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
        $geo_db_cities = $this[0]->getData()->data[0];
        $near_by_search = $this[1]->getData();

        $name = '';
        $name .= property_exists($geo_db_cities, 'region') ? "{$geo_db_cities->region} " : '';
        $name .= property_exists($geo_db_cities, 'name') ? "{$geo_db_cities->name}" : '';

        return [
            'name' => $name,
            'distance' => $geo_db_cities->distance,
            'direction' => $geo_db_cities->direction,
            'countryCode' => $geo_db_cities->countryCode,
            'icon' => $near_by_search->icon,
            'rating' => $near_by_search->rating,
            'photo' => $near_by_search->photo,
            'vicinity' => $near_by_search->vicinity,
            'userRatingsTotal' => $near_by_search->userRatingsTotal,
            'priceLevel' => $near_by_search->priceLevel,
            'lat' => $near_by_search->lat,
            'lng' => $near_by_search->lng,
            'placeId' => $near_by_search->placeId,
            'ratingStar' => $near_by_search->ratingStar,
        ];
    }
}
