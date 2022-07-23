<?php

namespace App\Services\RequestApis\GeoDBCities;

use App\Consts\ApiConst;
use App\Services\RequestApis\ApiService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Psr\Http\Message\ResponseInterface;

class GeoDBCitiesRandomRequestApiService
{
    private $response;
    private $body;

    /**
     * Request to API
     *
     * @param string $location
     * @return void
     */
    public function request(string $country_codes, string $name_prefix): self
    {
        $query = [
            'query' => [
                'limit' => '100',
                'radius' => '100',
                'countryIds' => $country_codes,
                'namePrefix' => $name_prefix
            ],
            'headers' => [
                'x-rapidapi-host' => 'wft-geo-db.p.rapidapi.com',
                'x-rapidapi-key' => config('const.geo_db_cities.api_key')
            ],
        ];
        $this->response = (new ApiService("GET", ApiConst::GEO_DB_CITIES, $query))->request();
        return $this;
    }

    /**
     * Get a response
     *
     * @throws ModelNotFoundException
     * @return void
     */
    public function get(): ResponseInterface
    {
        return $this->response;
    }

    /**
     * Verify the response and format it
     *
     * @throws ModelNotFoundException
     * @return array
     */
    public function body(): self
    {
        $body = json_decode($this->response->getBody(), true)['data'];
        if (empty($body)) {
            throw new ModelNotFoundException;
        }
        $this->body = $body;
        return $this;
    }

    /**
     * Get a body ramdomly
     *
     * @return array
     */
    public function getRandomly(): array
    {
        return $this->body[array_rand($this->body)];
    }
}
