<?php

namespace App\UseCases\Backpackers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Models\RequestCountHistory;
use App\Services\Countries\GetCountriesService;
use App\Services\Strings\FormatLocationService;
use App\Services\Contents\GetContentRandomlyService;
use App\Repositories\MCountries\MCountriesRepository;
use App\Services\Strings\GenerateStringRandomlyService;
use App\Repositories\GooglePlaceIds\GooglePlaceIdRepository;
use App\Http\Resources\Backpacker\BackpackerCitiesIndexResource;
use App\UseCases\RequestCountHistorys\RequestCountHistoryStoreUseCase;
use App\Repositories\RequestCountHistorys\RequestCountHistoryRepository;
use App\Services\RequestApis\NearBySearches\NearBySearchRequestApiService;
use App\Services\RequestApis\GeoDBCities\GeoDBCitiesRandomRequestApiService;

class BackpackerCitiesUseCase
{
    private $request;
    private $generateStringRandomlyService;
    private $getCountriesService;

    public function __construct(
        Request $request
    ) {
        $this->request = $request;
        $this->generateStringRandomlyService = new GenerateStringRandomlyService;
        $this->getCountriesService = new GetCountriesService(new MCountriesRepository());
        $this->geoDBCitiesRandomRequestApiService = new GeoDBCitiesRandomRequestApiService;
        $this->nearBySearchRequestApiService = new NearBySearchRequestApiService;
        $this->getContentRandomlyService = new GetContentRandomlyService;
        $this->requestCountHistoryStoreUseCase = new RequestCountHistoryStoreUseCase(new RequestCountHistoryRepository());
        $this->googlePlaceIdRepository = new GooglePlaceIdRepository;
    }

    public function handle(int $user_id): array
    {
        // Get a string randomly
        $str = $this->generateStringRandomlyService->get();

        // Get a country code randomly
        $country_code = $this->getCountriesService->get()->country_code;

        // Request to GeoDBCities
        $geo_db_cities =
            $this->geoDBCitiesRandomRequestApiService->request($country_code, $str)->body()->getRandomly();

        // Format latitude and longitude as a string
        $location = (new FormatLocationService($geo_db_cities['latitude'], $geo_db_cities['longitude']))->location();

        // Request to NearBySearch
        $this->nearBySearchRequestApiService->request($location, $this->setKeyword($geo_db_cities));

        // Get content randomly
        $this->getContentRandomlyService->handle($this->nearBySearchRequestApiService->response_body);

        $resource = (new BackpackerCitiesIndexResource([
            $geo_db_cities, $this->getContentRandomlyService->content,
        ]));

        DB::transaction(function () use ($user_id, $resource) {
            // Store request count history
            $this->requestCountHistoryStoreUseCase->handle($user_id, RequestCountHistory::TYPE_ID['backpackerCities']);

            // Store google place id
            $this->googlePlaceIdRepository->store($resource->resolve());
        });

        return $resource->jsonSerialize();
    }

    /**
     * Set keyword
     *
     * @return string
     */
    private function setKeyword(array $data): string
    {
        $keyword = '';
        $keyword .= array_key_exists('region', $data) ? "{$data['region']} " : '';
        $keyword .= array_key_exists('name', $data) ? "{$data['name']}" : '';
        return $keyword;
    }
}
