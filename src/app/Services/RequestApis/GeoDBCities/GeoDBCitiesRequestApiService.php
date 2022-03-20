<?php

namespace App\Services\RequestApis\GeoDBCities;

use App\Consts\ApiConst;
use App\Services\RequestApis\ApiService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GeoDBCitiesRequestApiService
{
    public $response;
    public $response_body;

    public function request(string $location)
    {
        $this->_request($location);
        $this->_getBody();
    }

    /**
     * Request to API
     *
     * @param string $location
     * @return void
     */
    public function _request(string $location): void
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
        $this->response = (new ApiService("GET", ApiConst::GEO_DB_CITIES, $query))->request();
    }

    /**
     * Verify the response and format it
     *
     * @throws ModelNotFoundException
     * @return void
     */
    public function _getBody(): void
    {
        $body = json_decode($this->response->getBody(), true)['data'];
        if (empty(json_decode($this->response->getBody(), true)['data'])) {
            throw new ModelNotFoundException;
        }
        $this->response_body = $body;
    }
}
