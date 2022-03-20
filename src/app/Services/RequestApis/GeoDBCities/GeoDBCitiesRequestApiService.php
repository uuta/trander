<?php

namespace App\Services\RequestApis\GeoDBCities;

use App\Consts\ApiConst;
use Psr\Http\Message\ResponseInterface;
use App\Services\RequestApis\ApiService;

class GeoDBCitiesRequestApiService
{
    /**
     * Request to API
     *
     * @param string $location
     * @return ResponseInterface
     */
    public function request(string $location): ResponseInterface
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
        return (new ApiService("GET", ApiConst::GEO_DB_CITIES, $query))->request();
    }
}
