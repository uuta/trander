<?php

namespace App\Services\Weather;

// Guzzleモジュールのクラス読み込み
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use App\Services\Factries\ExternalResponse\ExternalResponseFactory;

class Get extends ExternalResponseFactory
{
    protected $addedResponse = [
        'key' => [
            ['name' => 'temp', 'content' => "['main']['temp']"],
            ['name' => 'description', 'content' => "['weather'][0]['description']"],
            ['name' => 'weather_icon', 'content' => "['weather'][0]['icon']"],
            ['name' => 'date_time', 'content' => "['dt_txt']"],
            ['name' => 'rain', 'content' => "['rain']['3h']"],
            ['name' => 'snow', 'content' => "['snow']['3h']"],
        ],
        'response' => 'list',
        'hierarchy' => ExternalResponseFactory::HIERARCHY['second'],
    ];

    /**
     * Request to yahoo! local search API
     */
    public function apiRequest() {
        $client = new Client();
        $sourceUrl = "https://api.openweathermap.org/data/2.5/forecast";
        $this->response = $client->request("GET", $sourceUrl, [
            'query' => [
                'appid' => config('services.open_weather_map.app_id'),
                'lat' => $this->request->lat,
                'lon' => $this->request->lng,
                'lang' => 'ja',
                'units' => 'metric',
            ]
        ]);
    }
}
