<?php

namespace App\Http\Controllers;

use App\Http\Controllers\NormalizedController;
use App\Http\Requests\Cities\IndexRequest;
use App\Services\Cities\IndexService;
use App\Http\Resources\Cities\IndexResource;

class CitiesController extends NormalizedController
{
    public function index(IndexRequest $request) {
        $this->normarize_request($request);

        $geo_db_cities = IndexService::post_geo_db_cities_api($request);

        // Succeed
        if ($geo_db_cities->status() === 200) {
            $params = IndexService::generate_near_by_search_params($request, $geo_db_cities);
            $near_by_search = IndexService::get_near_by_search_api($params);
            return (new IndexResource([$geo_db_cities, $near_by_search]));
        }

        return Response($geo_db_cities->getContent(), $geo_db_cities->status());
    }
}
