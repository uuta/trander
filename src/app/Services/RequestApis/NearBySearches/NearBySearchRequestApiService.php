<?php

namespace App\Services\RequestApis\NearBySearches;

use App\Consts\ApiConst;
use Psr\Http\Message\ResponseInterface;
use App\Services\RequestApis\ApiService;

class NearBySearchRequestApiService
{
    /**
     * Request to API
     *
     * @param string $location
     * @param string $keyword
     * @return ResponseInterface
     */
    public function request(string $location, string $keyword): ResponseInterface
    {
        $query = [
            'query' => [
                'key' => config('services.google_places.key'),
                'location' => $location,
                'radius' => 5000,
                'keyword' => $keyword,
                'language' => 'en',
            ]
        ];
        return (new ApiService("GET", ApiConst::NEAR_BY_SEARCH, $query))->request();
    }
}
