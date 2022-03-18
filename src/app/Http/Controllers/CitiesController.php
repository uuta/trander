<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cities\IndexRequest;
use App\Services\Cities\IndexService;
use App\Http\Resources\Cities\IndexResource;
use App\UseCases\Cities\CitiesIndexUseCase;

class CitiesController extends Controller
{
    // TODO:
    // A user receives city information
    // API stores a history
    // API decreases the number of requests
    public function index(IndexRequest $request)
    {
        (new CitiesIndexUseCase())->handle($request);

        $geo_db_cities = IndexService::postGeoDbCitiesApi($request);

        // Succeed
        if ($geo_db_cities->status() === 200) {
            $params = IndexService::generateNearBySearchParams($request, $geo_db_cities);
            $near_by_search = IndexService::getNearBySearchApi($params, $request);
            return (new IndexResource([$geo_db_cities, $near_by_search]));
        }

        return Response($geo_db_cities->getContent(), $geo_db_cities->status());
    }
}
