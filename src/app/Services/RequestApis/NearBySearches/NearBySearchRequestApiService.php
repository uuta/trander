<?php

namespace App\Services\RequestApis\NearBySearches;

use App\Consts\ApiConst;
use App\Services\RequestApis\ApiService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class NearBySearchRequestApiService
{
    public $response;
    public $response_body;

    public function request(string $location, string $keyword)
    {
        $this->_request($location, $keyword);
        $this->_getBody();
    }

    /**
     * Request to API
     *
     * @param string $location
     * @param string $keyword
     * @return void
     */
    public function _request(string $location, string $keyword): void
    {
        $query = [
            'query' => [
                'key' => config('services.google_places.key'),
                'location' => $location,
                'radius' => 10000,
                'keyword' => $keyword,
                'language' => 'en',
            ]
        ];
        $this->response = (new ApiService("GET", ApiConst::NEAR_BY_SEARCH, $query))->request();
    }

    public function _getBody()
    {
        $body = json_decode($this->response->getBody(), true)['results'];
        if (empty(json_decode($this->response->getBody(), true)['results'])) {
            throw new ModelNotFoundException;
        }
        $this->response_body = $body;
    }
}
