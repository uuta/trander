<?php

namespace App\Services\Cities;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\JsonResponse;

class IndexService
{
    /**
     * Request to POST geo-db-cities API
     *
     * @param \Illuminate\Http\Request $request
     * @return object
     */
    public static function post_geo_db_cities_api(Request $request) : object
    {
        return app()->handle(Request::create('/api/external/geo-db-cities', 'POST', $request->all(), [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]));
    }

    /**
     * Request to GET near-by-search API
     *
     * @param array $params
     * @return object
     */
    public static function get_near_by_search_api(array $params) : object
    {
        return app()->handle(Request::create('/api/external/near-by-search', 'GET', $params, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . config('const.auth0.test_id_token')
        ]));
    }

    /**
     * Generate params for near_by_search API
     *
     * @param \Illuminate\Http\Request $request
     * @param object $geo_db_cities
     * @return array
     */
    public static function generate_near_by_search_params(Request $request, object $geo_db_cities) : array
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