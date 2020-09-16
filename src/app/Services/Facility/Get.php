<?php

namespace App\Services\Facility;

// Guzzleモジュールのクラス読み込み
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use App\Services\Factries\ExternalResponse\ExternalResponseFactory;

class Get extends ExternalResponseFactory
{
    protected $addedResponse = [
        'key' => [
            ['name' => 'name', 'content' => "['Name']"],
            ['name' => 'genre', 'content' => "['Property']['Genre'][0]['Name']"],
            ['name' => 'rating', 'content' => "['Property']['Rating']"],
            ['name' => 'lead_image', 'content' => "['Property']['LeadImage']"],
        ],
        'response' => 'Feature',
        'hierarchy' => ExternalResponseFactory::HIERARCHY['second'],
    ];

    /**
     * Request to yahoo! local search API
     * It doesn't need to return a response in general, but it requires a response for error handling
     *
     * @return object
     */
    public function apiRequest() : object
    {
        $client = new Client();
        $sourceUrl = "https://map.yahooapis.jp/search/local/V1/localSearch";
        $this->response = $client->request("GET", $sourceUrl, [
            'query' => [
                'appid' => config('services.yahoo_local_search.app_id'),
                'lat' => $this->request->lat,
                'lon' => $this->request->lng,
                'dist' => 5,
                'results' => 100,
                'sort' => 'hybrid',
                'output' => 'json'
            ]
        ]);
        return $this->response;
    }
}
