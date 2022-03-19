<?php

namespace App\Http\Domains\GeoDBCities\Request\UseCases;

// Guzzleモジュールのクラス読み込み
use Location\Coordinate;
use Location\Distance\Vincenty;
use App\Services\Facades\GenerateLocationService;
use App\Repositories\Directions\DirectionRepository;
use App\Repositories\GeoDBCities\GeoDBCitiesRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GeoDBCitiesRequestUseCase
{
    private $request;
    private $location;
    private $angle;
    private $response;
    private $service;
    private $geoDBCitiesRepository;
    private $directionRepository;

    public function __construct(object $request)
    {
        $this->request = $request;
        $this->service = new GenerateLocationService($request);
        $this->geoDBCitiesRepository = new GeoDBCitiesRepository();
        $this->directionRepository = new DirectionRepository();
    }

    public function handle()
    {
        $this->_generateFormattedLocation();
        $this->_getAngle();
        $this->_request();
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

    private function _request(): void
    {
        $this->response = $this->geoDBCitiesRepository->request($this->location);
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
        $data['direction'] = $this->directionRepository->findByAngle($this->angle);
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
}
