<?php

namespace App\Http\Controllers\External;

use Illuminate\Support\Facades\Log;
use App\Services\GeoDBCitiesApi;
use App\Http\Requests\GeoDBCitiesApiRequest;
use App\Http\Requests\GeoDBCities\GetIdRequest;
use App\Http\Controllers\NormalizedController;
use GuzzleHttp\Exception\BadResponseException;
use App\Services\Facades\GenerateLocation;
use App\RequestCountHistory;
use App\Services\GeoDBCities\GetId as GeoDBCitiesGetId;

class GeoDBCitiesApiController extends NormalizedController
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
        $location = $Randomization->generate_formatted_location();
        $angle = $Randomization->get_angle();

        $response = $this->GeoDBCitiesApi->api_request($location);
        $addedResponse = $this->GeoDBCitiesApi->add_request($request, $response, $angle);

        if (empty($addedResponse['data'])) {
            return Response([], 204);
        }
        return $addedResponse;
    }

    public function index(GetIdRequest $request)
    {
        try
        {
            $this->normarize_request($request);

            // Request
            $GeoDBCitiesGetId = new GeoDBCitiesGetId($request);
            $GeoDBCitiesGetId->apiRequest();
            $GetResponse = $GeoDBCitiesGetId->get_response();
            $response = $GetResponse->formatResponse();

            // Insert a request history
            $requestCountHistory = new RequestCountHistory();
            $requestCountHistory->setHistory(RequestCountHistory::TYPE_ID['getGeoDbCitiesId'], $request->all()['userinfo']->id);

            return $this->normarize_response($response);
        }
        catch (BadResponseException $e)
        {
            $response = json_decode($e->getResponse()->getBody()->getContents(), true);
            return response()->json($response, $e->getResponse()->getStatusCode());
        }
    }
}
