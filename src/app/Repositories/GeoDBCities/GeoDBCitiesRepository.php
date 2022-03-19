<?php

namespace App\Repositories\GeoDBCities;

use App\Services\ApiService;
use Psr\Http\Message\ResponseInterface;

class GeoDBCitiesRepository
{
    /**
     * Request to API
     *
     * @return void
     */
    public function request($location): ResponseInterface
    {
        $query = [
            'query' => [
                'limit' => '1',
                'location' => $location,
                'radius' => '100',
            ],
            'headers' => [
                'x-rapidapi-host' => 'wft-geo-db.p.rapidapi.com',
                'x-rapidapi-key' => config('const.geo_db_cities.api_key')
            ],
        ];
        return (new ApiService)->request("GET", "https://wft-geo-db.p.rapidapi.com/v1/geo/cities", $query);
    }
}
