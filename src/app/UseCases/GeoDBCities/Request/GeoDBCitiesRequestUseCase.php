<?php

namespace App\UseCases\GeoDBCities\Request;

// Guzzleモジュールのクラス読み込み
use App\Services\Facades\GenerateLocationService;
use App\Repositories\Directions\DirectionRepository;
use App\Services\RequestApis\GeoDBCities\GeoDBCitiesRequestApiService;
use App\UseCases\RequestCountHistorys\RequestCountHistoryStoreUseCase;
use App\Repositories\RequestCountHistorys\RequestCountHistoryRepository;

class GeoDBCitiesRequestUseCase
{
    private $request;
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
        // Generate location randomly
        $this->generateLocationService->handle($this->request);

        // Request to GeoDBCities
        $this->geoDBCitiesRequestApiService->request($this->generateLocationService->formatted_location);

        // Store request count history
        $this->requestCountHistoryStoreUseCase->handle($user_id, $type_id);

        return $this->_return();
    }

    /**
     * Return the response
     *
     * @return array
     */
    private function _return(): array
    {
        $data = $this->geoDBCitiesRequestApiService->response_body[0];
        $data['angle'] = $this->generateLocationService->angle;
        $data['distance'] = $this->generateLocationService->getDistance($data['latitude'], $data['longitude']);
        $data['direction'] = $this->directionRepository->findByAngle($this->generateLocationService->angle);
        return $data;
    }
}
