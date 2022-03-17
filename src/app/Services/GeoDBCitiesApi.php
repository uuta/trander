<?php

namespace App\Services;

// Guzzleモジュールのクラス読み込み
use GuzzleHttp\Client;
use Location\Coordinate;
use Location\Distance\Vincenty;
use Illuminate\Support\Facades\DB;
use App\MWay;

class GeoDBCitiesApi
{
  private $direction;
  private $angle;
  private $distance;
  private $ways;

  /**
   * GeoDBCitiesにリクエストを送信してレスポンスを受け取る
   *
   * @param string $location
   * @return object
   */
  public function apiRequest($location): object
  {
    $client = new Client();
    $sourceUrl = "https://wft-geo-db.p.rapidapi.com/v1/geo/cities";
    $response = $client->request("GET", $sourceUrl, [
      'query' => [
        'limit' => '1',
        'location' => $location,
        'radius' => '100',
      ],
      'headers' => [
        'x-rapidapi-host' => 'wft-geo-db.p.rapidapi.com',
        'x-rapidapi-key' => config('const.geo_db_cities.api_key')
      ],
    ]);
    return $response;
  }

  /**
   * レスポンスに情報を追加する
   *
   * @param object $request
   * @param object $response
   * @param float $angle
   * @return array
   */
  public function addRequest(object $request, object $response, float $angle): array
  {
    $responseBody = json_decode($response->getBody()->getContents(), true);

    // レスポンスの距離を上書きする
    foreach ($responseBody['data'] as &$data) {
      $this->getDistance($request, $data);
      $data['distance'] = $this->distance;
    }

    // レスポンスに移動手段の推奨度を追加する
    foreach ($responseBody['data'] as &$data) {
      $this->getWayOfRecommend();
      $data['ways'] = $this->ways;
    }

    // レスポンスに方角を追加する
    foreach ($responseBody['data'] as &$data) {
      $this->getDirection($angle);
      $data['direction'] = $this->direction;
    }

    return $responseBody;
  }

  /**
   * 現在地と街までの距離を取得する
   *
   * @param object $request
   * @param array $response
   */
  private function getDistance(object $request, array $response)
  {
    $coordinate1 = new Coordinate($request->lat, $request->lng);
    $coordinate2 = new Coordinate($response['latitude'], $response['longitude']);
    $calculator = new Vincenty();
    $distance = ($calculator->getDistance($coordinate1, $coordinate2) * 0.001);
    $this->distance = (float)round($distance, 1);
  }

  /**
   * Get the recommend frequencies of ways
   */
  private function getWayOfRecommend()
  {
    $ways = [];
    foreach (MWay::WAYS as $key => $value) {
      $way = DB::table('m_ways')->where([
        ['way_id', $value],
        ['min_distance', '<=', $this->distance],
        ['max_distance', '>', $this->distance]
      ])->get();
      $ways[$key] = $way[0]->recommend_frequency;
    }
    $this->ways = $ways;
  }

  /**
   * Get a direction from the angle
   *
   * @param float $angle
   */
  private function getDirection(float $angle)
  {
    $data = DB::table('m_directions')->where([
      ['min_angle', '<=', $angle],
      ['max_angle', '>', $angle]
    ])->get();
    $this->direction = $data[0]->direction_name;
  }
}
