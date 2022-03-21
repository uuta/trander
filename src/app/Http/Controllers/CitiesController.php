<?php

namespace App\Http\Controllers;

use App\Http\Models\RequestCountHistory;
use App\UseCases\Cities\Index\CityIndexUseCase;
use App\Http\Requests\Cities\CitiesIndexRequest;
use App\Services\Facades\GenerateLocationService;
use App\Repositories\Directions\DirectionRepository;
use App\Services\Contents\GetContentRandomlyService;
use App\Repositories\GooglePlaceIds\GooglePlaceIdRepository;
use App\Services\RequestApis\GeoDBCities\GeoDBCitiesRequestApiService;
use App\Services\RequestApis\NearBySearches\NearBySearchRequestApiService;

class CitiesController extends Controller
{
    public function index(
        CitiesIndexRequest $request,
        GenerateLocationService $generateLocationService,
        GeoDBCitiesRequestApiService $geoDBCitiesRequestApiService,
        NearBySearchRequestApiService $nearBySearchRequestApiService,
        GooglePlaceIdRepository $googlePlaceIdRepository,
        GetContentRandomlyService $getContentRandomlyService,
        DirectionRepository $directionRepository
    ) {
        return (new CityIndexUseCase(
            $request,
            $generateLocationService,
            $geoDBCitiesRequestApiService,
            $nearBySearchRequestApiService,
            $googlePlaceIdRepository,
            $getContentRandomlyService,
            $directionRepository
        ))->handle(
            $request->all()['userinfo']->id,
            RequestCountHistory::TYPE_ID['indexCities']
        );
    }
}
