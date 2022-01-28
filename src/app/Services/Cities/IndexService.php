<?php

namespace App\Services\Cities;

use Illuminate\Http\Request;
use App\Http\Requests\Cities\IndexRequest;

class IndexService
{
    /**
     * Request to POST geo-db-cities API
     *
     * @param \Illuminate\Http\Request $request
     * @return object
     */
    public static function postGeoDbCitiesApi(Request $request): object
    {
        return app()->handle(Request::create('/api/external/geo-db-cities', 'POST', $request->all(), [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . $request->bearerToken()
        ]));
    }

    /**
     * Request to GET near-by-search API
     *
     * @param array $params
     * @return object
     */
    public static function getNearBySearchApi(array $params, IndexRequest $request): object
    {
        return app()->handle(Request::create('/api/external/near-by-search', 'GET', $params, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . $request->bearerToken()
        ]));
    }

    /**
     * Generate params for near_by_search API
     *
     * @param \Illuminate\Http\Request $request
     * @param object $geo_db_cities
     * @return array
     */
    public static function generateNearBySearchParams(Request $request, object $geo_db_cities): array
    {
        $params = [];
        $keyword = '';
        $params = $request->all();
        $data = $geo_db_cities->getData()->data[0];
        $keyword .= property_exists($data, 'region') ? "{$data->region} " : '';
        $keyword .= property_exists($data, 'name') ? "{$data->name}" : '';
        $params['lat'] = $data->latitude;
        $params['lng'] = $data->longitude;
        $params['min'] = 0;
        $params['max'] = 0;
        $params['keyword'] = $keyword;
        return $params;
    }
}
