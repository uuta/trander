<?php

namespace App\Http\Resources\GeoDBCities;

use Illuminate\Http\Resources\Json\JsonResource;

class GeoDBCitiesRequestResource extends JsonResource
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
            'city' => $resource['city'],
            'countryCode' => $resource['countryCode'],
            'region' => $resource['region'],
            'latitude' => $resource['latitude'],
            'longitude' => $resource['longitude'],
            'angle' => $resource['angle'],
            'distance' => $resource['distance'],
            'direction' => $resource['direction']
        ];
    }
}
