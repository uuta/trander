<?php

namespace App\Services\GeoDBCities;

// Guzzleモジュールのクラス読み込み
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use App\Services\Factries\ExternalResponse\ExternalResponseFactory;

class GetId extends ExternalResponseFactory
{
    protected $addedResponse = [
        'key' => [
            ['name' => 'city', 'content' => "['city']"],
            ['name' => 'country', 'content' => "['country']"],
            ['name' => 'countryCode', 'content' => "['countryCode']"],
            ['name' => 'latitude', 'content' => "['latitude']"],
            ['name' => 'longitude', 'content' => "['longitude']"],
            ['name' => 'name', 'content' => "['name']"],
            ['name' => 'region', 'content' => "['region']"],
            ['name' => 'wikiDataId', 'content' => "['wikiDataId']"],
        ],
        'response' => 'data',
        'hierarchy' => ExternalResponseFactory::HIERARCHY['first'],
    ];

    /**
     * Request to yahoo! local search API
     */
    public function apiRequest() {
        $client = new Client();
        $sourceUrl = "https://wft-geo-db.p.rapidapi.com/v1/geo/cities/".$this->request->id;
        $this->response = $client->request("GET", $sourceUrl, [
            'headers' => [
                'x-rapidapi-host' => 'wft-geo-db.p.rapidapi.com',
                'x-rapidapi-key' => config('const.geo_db_cities.api_key')
            ],
        ]);
    }
}
