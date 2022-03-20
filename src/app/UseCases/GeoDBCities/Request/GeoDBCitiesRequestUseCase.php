<?php

namespace App\UseCases\GeoDBCities\Request;

// Guzzleモジュールのクラス読み込み
use Location\Coordinate;
use Location\Distance\Vincenty;
use App\Services\Facades\GenerateLocationService;
use App\Repositories\Directions\DirectionRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\RequestApis\GeoDBCities\GeoDBCitiesRequestApiService;

class GeoDBCitiesRequestUseCase
{
    private $request;
    private $location;
    private $angle;
    private $response;
    private $generateLocationService;
    private $geoDBCitiesRequestApiService;
    private $directionRepository;

    public function __construct(
        object $request,
        GenerateLocationService $generateLocationService,
        GeoDBCitiesRequestApiService $geoDBCitiesRequestApiService,
        DirectionRepository $directionRepository
    ) {
        $this->request = $request;
        $this->generateLocationService = $generateLocationService;
        $this->geoDBCitiesRequestApiService = $geoDBCitiesRequestApiService;
        $this->directionRepository = $directionRepository;
    }

    public function handle()
    {
        $this->_handleLocation();
        $this->_generateFormattedLocation();
        $this->_getAngle();
        $this->_request();
        $this->_verifyEmpty();
        return $this->_return();
    }

    /**
     * Handle location
     *
     * @return void
     */
    private function _handleLocation(): void
    {
        $this->generateLocationService->handle($this->request);
    }

    public function _generateFormattedLocation(): void
    {
        $this->location = $this->generateLocationService->generateFormattedLocation();
    }

    public function _getAngle(): void
    {
        $this->angle = $this->generateLocationService->getAngle();
    }

    private function _request(): void
    {
        $this->response = $this->geoDBCitiesRequestApiService->request($this->location);
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
