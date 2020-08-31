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
        $sourceUrl = "https://app.rakuten.co.jp/services/api/Travel/SimpleHotelSearch/20170426";
        $response = $client->request("GET", $sourceUrl, [
            'query' => [
                'applicationId' => config('services.rakuten_hotel_search.app_id'),
                'affiliateId' => config('services.rakuten_hotel_search.affiliate_id'),
                'latitude' => 43.067883,
                'longitude' => 141.322995,
                'searchRadius' => 3,
                'datumType' => 1,
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
