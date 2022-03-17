<?php

namespace App\UseCases\GeoDBCities;


// Guzzleモジュールのクラス読み込み
use GuzzleHttp\Client;
use Location\Coordinate;
use Location\Distance\Vincenty;
use Illuminate\Support\Facades\DB;
use App\Services\Facades\GenerateLocationService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GeoDBCitiesRequestUseCase
{
    private $request;
    private $location;
    private $angle;
    private $response;
    private $service;

    public function __construct(object $request)
    {
        $this->request = $request;
        $this->service = new GenerateLocationService($request);
    }

    public function handle()
    {
        $this->_generateFormattedLocation();
        $this->_getAngle();
        $this->_apiRequest();
        $this->_verifyEmpty();
        return $this->_return();
    }

    public function _generateFormattedLocation(): void
    {
        $this->location = $this->service->generateFormattedLocation();
    }

    public function _getAngle(): void
    {
        $this->angle = $this->service->getAngle();
    }

    /**
     * GeoDBCitiesにリクエストを送信してレスポンスを受け取る
     *
     * @return void
     */
    public function _apiRequest(): void
    {
        $client = new Client();
        $sourceUrl = "https://wft-geo-db.p.rapidapi.com/v1/geo/cities";
        $this->response = $client->request("GET", $sourceUrl, [
            'query' => [
                'limit' => '1',
                'location' => $this->location,
                'radius' => '100',
            ],
            'headers' => [
                'x-rapidapi-host' => 'wft-geo-db.p.rapidapi.com',
                'x-rapidapi-key' => config('const.geo_db_cities.api_key')
            ],
        ]);
    }

    /**
     * Verify the response and format it
     *
     * @throws ModelNotFoundException
     * @return void
     */
    public function _verifyEmpty(): void
    {
        if (empty(json_decode($this->response->getBody(), true)['data'])) {
            throw new ModelNotFoundException;
        }
    }

    /**
     * Return the response
     *
     * @return array
     */
    public function _return(): array
    {
        $data = json_decode($this->response->getBody(), true)['data'][0];
        $data['angle'] = $this->angle;
        $data['distance'] = $this->_getDistance($data['latitude'], $data['longitude']);
        $data['direction'] = $this->_getDirection();
        return $data;
    }

    /**
     * 現在地と街までの距離を取得する
     *
     * @param float $latitude
     * @param float $longitude
     * @return float
     */
    private function _getDistance(float $latitude, float $longitude): float
    {
        $coordinate1 = new Coordinate($this->request->lat, $this->request->lng);
        $coordinate2 = new Coordinate($latitude, $longitude);
        $calculator = new Vincenty();
        $distance = ($calculator->getDistance($coordinate1, $coordinate2) * 0.001);
        return (float)round($distance, 1);
    }

    /**
     * Get a direction from the angle
     *
     * @return float
     */
    private function _getDirection(): string
    {
        $data = DB::table('m_directions')->where([
            ['min_angle', '<=', $this->angle],
            ['max_angle', '>', $this->angle]
        ])->get();
        return $data[0]->direction_name;
    }
}
