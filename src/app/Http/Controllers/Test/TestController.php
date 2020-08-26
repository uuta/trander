<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function index()
    {
        $client = new Client();
        $sourceUrl = "https://map.yahooapis.jp/search/local/V1/localSearch";
        $response = $client->request("GET", $sourceUrl, [
            'query' => [
                'appid' => 'dj00aiZpPXBBQ1R1c2p1enVZdiZzPWNvbnN1bWVyc2VjcmV0Jng9MTU-',
                'lat' => 35.729013,
                'lon' => 139.708185,
                'dist' => 5,
                'sort' => 'hybrid',
                'query' => '温泉',
                'output' => 'json'
            ]
        ]);
        $responseBody = json_decode($response->getBody()->getContents(), true);
        return $responseBody;
    }

    public function weather()
    {
        $client = new Client();
        $sourceUrl = "https://api.openweathermap.org/data/2.5/forecast";
        $response = $client->request("GET", $sourceUrl, [
            'query' => [
                'appid' => '79697f49246abcc3f454e07df1853310',
                'lat' => -74.694581,
                'lon' =>  164.112461,
                'lang' => 'ja',
                'units' => 'metric',
            ]
        ]);
        $responseBody = json_decode($response->getBody()->getContents(), true);
        return $responseBody;
    }
}
