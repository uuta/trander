<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmptyResource;
use App\Http\Models\RequestCountHistory;
use GuzzleHttp\Exception\BadResponseException;
use App\UseCases\Cities\Index\CityIndexUseCase;
use App\Http\Requests\Cities\CitiesIndexRequest;
use App\Services\Facades\GenerateLocationService;
use App\Repositories\Directions\DirectionRepository;
use App\Services\Contents\GetContentRandomlyService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        try {
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
        } catch (ModelNotFoundException $e) {
            return response()->json((new EmptyResource([])), 204);
        } catch (BadResponseException $e) {
            return response()->json(json_decode($e->getResponse()->getBody()->getContents(), true), 500);
        }
    }
}
