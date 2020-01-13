<?php

namespace App\Http\Controllers\External;

use Illuminate\Http\Request;
// Guzzleモジュールのクラス読み込み
use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class GeoDBCitiesApiController extends Controller
{
  public function request(Request $request)
  {
    if (strpos($request->lat, '-') !== true) {
      $lat = '+' . $request->lat;
    }
    if (strpos($request->lng, '-') !== true) {
      $lng = '+' . $request->lng;
    }
    $location = $lat . $lng;

    $client = new Client();
    $sourceUrl = "https://wft-geo-db.p.rapidapi.com/v1/geo/cities";
    $responseData = $client->request("GET", $sourceUrl, [
      'query' => [
        'limit' => '10',
        'countryIds' => 'JP',
        'location' => $location,
        'radius' => '100',
        'types' => 'CITY'
      ],
      'headers' => [
        'x-rapidapi-host' => 'wft-geo-db.p.rapidapi.com',
        'x-rapidapi-key' => env('GEO_DB_CITIES_API')
      ],
    ]);
    $responseBody = json_decode($responseData->getBody()->getContents(), true);
    return [
      'status' => 'OK',
      'data' => $responseBody,
    ];
  }
}
