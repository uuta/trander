<?php

namespace App\Http\Controllers\External;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Services\GeoDBCitiesApi;
use App\Http\Requests\GeoDBCitiesApiRequest;

class GeoDBCitiesApiController extends Controller
{
    protected $GeoDBCitiesApi;

    public function __construct(GeoDBCitiesApi $GeoDBCitiesApi)
    {
        $this->GeoDBCitiesApi = $GeoDBCitiesApi;
    }

    public function request(GeoDBCitiesApiRequest $request)
    {
        $location = $this->GeoDBCitiesApi->getLatAndLng($request);
        $response = $this->GeoDBCitiesApi->apiRequest($location);
        $addedResponse = $this->GeoDBCitiesApi->addRequest($request, $response);
        return $addedResponse;
    }
}
