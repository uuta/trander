<?php

namespace App\UseCases\Cities\Index;

use Illuminate\Support\Facades\DB;
use App\Services\Facades\GenerateLocationService;
use App\Http\Resources\Cities\CitiesIndexResource;
use App\Repositories\Directions\DirectionRepository;
use App\Services\Contents\GetContentRandomlyService;
use App\Repositories\GooglePlaceIds\GooglePlaceIdRepository;
use App\Services\RequestApis\GeoDBCities\GeoDBCitiesRequestApiService;
use App\UseCases\RequestCountHistorys\RequestCountHistoryStoreUseCase;
use App\Repositories\RequestCountHistorys\RequestCountHistoryRepository;
use App\Services\RequestApis\NearBySearches\NearBySearchRequestApiService;

class CityIndexUseCase
{
    private $request;
    private $generateLocationService;
    private $geoDBCitiesRequestApiService;
    private $nearBySearchRequestApiService;
    private $googlePlaceIdRepository;
    private $getContentRandomlyService;
    private $directionRepository;

    public function __construct(
        object $request,
        GenerateLocationService $generateLocationService,
        GeoDBCitiesRequestApiService $geoDBCitiesRequestApiService,
        NearBySearchRequestApiService $nearBySearchRequestApiService,
        GooglePlaceIdRepository $googlePlaceIdRepository,
        GetContentRandomlyService $getContentRandomlyService,
        DirectionRepository $directionRepository
    ) {
        $this->request = $request;
        $this->generateLocationService = $generateLocationService;
        $this->geoDBCitiesRequestApiService = $geoDBCitiesRequestApiService;
        $this->nearBySearchRequestApiService = $nearBySearchRequestApiService;
        $this->googlePlaceIdRepository = $googlePlaceIdRepository;
        $this->getContentRandomlyService = $getContentRandomlyService;
        $this->directionRepository = $directionRepository;
        $this->requestCountHistoryStoreUseCase = new RequestCountHistoryStoreUseCase(new RequestCountHistoryRepository());
    }

    public function handle(int $user_id, int $type_id)
    {
        // Generate location randomly
        $this->generateLocationService->handle($this->request);

        // Request to GeoDBCities
        $this->geoDBCitiesRequestApiService->request($this->generateLocationService->formatted_location);

        // Request to NearBySearch
        $this->nearBySearchRequestApiService->request($this->generateLocationService->location, $this->setKeyword());

        // Get content randomly
        $this->getContentRandomlyService->handle($this->nearBySearchRequestApiService->response_body);

        $resource = (new CitiesIndexResource([
            $this->geoDBCitiesRequestApiService->response_body[0], $this->getContentRandomlyService->content,
            $this->generateLocationService,
            $this->directionRepository
        ]));

        return DB::transaction(function () use ($user_id, $type_id, $resource) {
            // Store request count history
            $this->requestCountHistoryStoreUseCase->handle($user_id, $type_id);

            // Store google place id
            $this->googlePlaceIdRepository->store($resource->resolve());

            return $resource->jsonSerialize();
        });
    }

    /**
     * Set keyword
     *
     * @return string
     */
    private function setKeyword(): string
    {
        $data = $this->geoDBCitiesRequestApiService->response_body[0];
        $keyword = '';
        $keyword .= array_key_exists('region', $data) ? "{$data['region']} " : '';
        $keyword .= array_key_exists('name', $data) ? "{$data['name']}" : '';
        return $keyword;
    }
}
