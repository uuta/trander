<?php

namespace App\Http\Controllers\External;

use App\RequestCountHistory;
use App\Services\GeoDBCitiesApi;
use App\Http\Controllers\Controller;
use App\Services\Facades\GenerateLocation;
use App\Http\Requests\GeoDBCitiesApiRequest;
use GuzzleHttp\Exception\BadResponseException;
use App\Http\Requests\GeoDBCities\GetIdRequest;
use App\Services\GeoDBCities\GetId as GeoDBCitiesGetId;

class GeoDBCitiesApiController extends Controller
{
    protected $GeoDBCitiesApi;

    public function __construct(GeoDBCitiesApi $GeoDBCitiesApi)
    {
        $this->GeoDBCitiesApi = $GeoDBCitiesApi;
    }

    public function request(GeoDBCitiesApiRequest $request)
    {
        // Generate location
        $Randomization = new GenerateLocation($request);
        $location = $Randomization->generateFormattedLocation();
        $angle = $Randomization->getAngle();

        $response = $this->GeoDBCitiesApi->api_request($location);
        $addedResponse = $this->GeoDBCitiesApi->add_request($request, $response, $angle);

        if (empty($addedResponse['data'])) {
            return Response([], 204);
        }
        return $addedResponse;
    }

    public function index(GetIdRequest $request)
    {
        try {
            // Request
            $GeoDBCitiesGetId = new GeoDBCitiesGetId($request);
            $GeoDBCitiesGetId->apiRequest();
            $GetResponse = $GeoDBCitiesGetId->getResponse();
            $response = $GetResponse->formatResponse();

            // Insert a request history
            $requestCountHistory = new RequestCountHistory();
            $requestCountHistory->setHistory(RequestCountHistory::TYPE_ID['getGeoDbCitiesId'], $request->all()['userinfo']->id);

            return $response;
        } catch (BadResponseException $e) {
            $response = json_decode($e->getResponse()->getBody()->getContents(), true);
            return response()->json($response, $e->getResponse()->getStatusCode());
        }
    }
}
