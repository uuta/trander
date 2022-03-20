<?php

namespace App\UseCases\GeoDBCities\Request;

// Guzzleモジュールのクラス読み込み
use App\Services\Facades\GenerateLocationService;
use App\Repositories\Directions\DirectionRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\RequestApis\GeoDBCities\GeoDBCitiesRequestApiService;
use App\UseCases\RequestCountHistorys\RequestCountHistoryStoreUseCase;
use App\Repositories\RequestCountHistorys\RequestCountHistoryRepository;

class GeoDBCitiesRequestUseCase
{
    private $request;
    private $location;
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
        $this->requestCountHistoryStoreUseCase = new RequestCountHistoryStoreUseCase(new RequestCountHistoryRepository());
    }

    public function handle(int $user_id, int $type_id)
    {
        $this->_handleLocation();
        $this->_generateFormattedLocation();
        $this->_request();
        $this->_verifyEmpty();

        // Store request count history
        $this->requestCountHistoryStoreUseCase->handle($user_id, $type_id);

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
        $angle = $this->generateLocationService->getAngle();
        $data = json_decode($this->response->getBody(), true)['data'][0];
        $data['angle'] = $angle;
        $data['distance'] = $this->generateLocationService->getDistance($data['latitude'], $data['longitude']);
        $data['direction'] = $this->directionRepository->findByAngle($angle);
        return $data;
    }
}
