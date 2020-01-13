<?php

namespace App\Http\Controllers\External;

use Illuminate\Http\Request;
// Guzzleモジュールのクラス読み込み
use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Location\Bearing\BearingEllipsoidal;
use Location\Bearing\BearingSpherical;
use Location\Coordinate;
use Location\Formatter\Coordinate\DecimalDegrees;

class GeoDBCitiesApiController extends Controller
{
  public function request(Request $request)
  {
    $location = $this->getLatAndLng($request);

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

  /**
   * 現在地を元にランダムに地点を取得する
   *
   * @param  object  $request
   * @return  string
   */
  public function getLatAndLng($request)
  {
    $currentLocation = new Coordinate($request->lat, $request->lng);
    $bearingEllipsoidal = new BearingEllipsoidal();
    $angle = $this->generateAngle();
    $distance = $this->generateDistance();
    Log::debug('角度は' . $angle);
    Log::debug('距離は' . $distance);
    $destination = $bearingEllipsoidal->calculateDestination($currentLocation, $angle, $distance);
    $commaDestination = $destination->format(new DecimalDegrees(','));
    Log::debug('緯度経度は' . $commaDestination);
    $location = $this->adjustLatAndLngFormat($commaDestination);
    return $location;
  }

  /**
   * ランダムに角度を生成する
   *
   * @return  double
   */
  public function generateAngle()
  {
    $max = 360;
    $rand_f = rand() / mt_getrandmax() * $max;
    return $rand_f;
  }

  /**
   * ランダムに距離を生成する
   *
   * @return  double
   */
  public function generateDistance()
  {
    $min = 10000;
    $max = 100000;
    $rand_f = rand($min, $max);
    return $rand_f;
  }

  /**
   * 緯度経度のフォーマットを整える
   *
   * @param  string $destination
   * @return  string
   */
  public function adjustLatAndLngFormat($destination)
  {
    $adjustDestination = '';
    $arr = explode(',', $destination);
    foreach ($arr as $value) {
      if (strpos($value, '-') !== true) {
        $value = '+' . $value;
      }
      $adjustDestination .= $value;
    }
    return $adjustDestination;
  }
}
