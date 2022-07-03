<?php

namespace App\UseCases\Backpackers;

use Illuminate\Http\Request;
use App\Services\Countries\GetCountriesService;
use App\Repositories\MCountries\MCountriesRepository;
use App\Services\Strings\GenerateStringRandomlyService;
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
    }

    public function handle()
    {
        $str = $this->generateStringRandomlyService->get();
        $country_code = $this->getCountriesService->get()->country_code;
        return $this->geoDBCitiesRandomRequestApiService->request($country_code, $str)->getBody();
    }
}
