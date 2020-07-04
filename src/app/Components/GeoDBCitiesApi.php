<?php

namespace App\Components;

// Guzzleモジュールのクラス読み込み
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Location\Bearing\BearingEllipsoidal;
use Location\Coordinate;
use Location\Formatter\Coordinate\DecimalDegrees;
use Location\Distance\Vincenty;
use Illuminate\Support\Facades\DB;
use App\Mway;

class GeoDBCitiesApi
{
  /**
   * 現在地を元にランダムに地点を取得する
   * @param  object  $request
   * @return  string
   */
  public function getLatAndLng($request)
  {
    $currentLocation = new Coordinate($request->lat, $request->lng);
    $bearingEllipsoidal = new BearingEllipsoidal();
    $angle = $this->generateAngle();
    $distance = $this->generateDistance($request);
    $destination = $bearingEllipsoidal->calculateDestination($currentLocation, $angle, $distance);
    $commaDestination = $destination->format(new DecimalDegrees(','));
    $location = $this->adjustLatAndLngFormat($commaDestination);
    return $location;
  }

  /**
   * ランダムに角度を生成する
   * @return  double
   */
  private function generateAngle()
  {
    $max = 360;
    $rand_f = rand() / mt_getrandmax() * $max;
    return $rand_f;
  }

  /**
   * ランダムに距離を生成する
   * @return  double
   */
  private function generateDistance($request)
  {
    $min = $request->min;
    $max = $request->max;
    $rand_f = rand($min, $max);
    return $rand_f;
  }

  /**
   * 緯度経度のフォーマットを整える
   * @param  string $destination
   * @return  string
   */
  private function adjustLatAndLngFormat($destination)
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

  /**
   * GeoDBCitiesにリクエストを送信してレスポンスを受け取る
   * @param  string  $location
   * @return  array
   */
  public function apiRequest($location)
  {
    $client = new Client();
    $sourceUrl = "https://wft-geo-db.p.rapidapi.com/v1/geo/cities";
    $response = $client->request("GET", $sourceUrl, [
      'query' => [
        'limit' => '1',
        'countryIds' => 'JP',
        'location' => $location,
        'radius' => '100',
      ],
      'headers' => [
        'x-rapidapi-host' => 'wft-geo-db.p.rapidapi.com',
        'x-rapidapi-key' => env('GEO_DB_CITIES_API')
      ],
    ]);
    return $response;
  }

  /**
   * レスポンスに情報を追加する
   * @param  object  $request
   * @param  object  $response
   * @return  array
   */
  public function addRequest(object $request, object $response)
  {
    $responseBody = json_decode($response->getBody()->getContents(), true);

    // レスポンスの距離を上書きする
    foreach($responseBody['data'] as &$data) {
      $distance = $this->getDistance($request, $data);
      $data['distance'] = $distance;
    }

    // レスポンスに移動手段の推奨度を追加する
    foreach($responseBody['data'] as &$data) {
      $ways = $this->getWayOfRecommend($distance);
      $data['ways'] = $ways;
    }

    // レスポンスにステータスコードを追加する
    $status = $response->getStatusCode();
    $responseBody += ['status' => $status];

    if ($status === 200 && $responseBody['data'] === []) {
      $responseBody['status'] = 204;
      unset($responseBody['data']);
      $responseBody +=
        [
          'errors' => [
            'code' => 'データなし',
            'message' => '該当するデータが存在しませんでした。距離を変更のうえ再度お試しください。'
          ]
        ];
    }
    return $responseBody;
  }

  /**
   * 現在地と街までの距離を取得する
   * @param object $request: リクエスト
   * @param array $response: レスポンス
   * @return float
   */
  private function getDistance(object $request, array $response) : float
  {
    $coordinate1 = new Coordinate($request->lat, $request->lng);
    $coordinate2 = new Coordinate($response['latitude'], $response['longitude']);
    $calculator = new Vincenty();
    $distance = ($calculator->getDistance($coordinate1, $coordinate2) * 0.001);
    return round($distance, 1);
  }

  /**
   * Get the recommend frequencies of ways
   * @param float $distance: 距離
   * @return array
   */
  private function getWayOfRecommend($distance) : array
  {
    $ways = [];
    foreach(MWay::WAYS as $key => $value) {
      $way = DB::table('m_ways')->where([
        ['way_id', $value],
        ['min_distance', '<=', $distance],
        ['max_distance', '>', $distance]
      ])->get();
      $ways[$key] = $way[0]->recommend_frequency;
    }
    return $ways;
  }
}
