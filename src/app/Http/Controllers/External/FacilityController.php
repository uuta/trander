<?php

namespace App\Http\Controllers\External;

use Illuminate\Http\Request;
use App\Http\Controllers\NormalizedController;
use App\Services\Facility\Get as FacilityGet;
use App\Http\Requests\Facility\GetRequest;
use GuzzleHttp\Exception\BadResponseException;
use App\RequestCountHistory;

class FacilityController extends NormalizedController
{
    public function index(GetRequest $request)
    {
        try
        {
            $this->normarize_request($request);

            // Request
            $FacilityGet = new FacilityGet($request);

            $facilityGetResponse = $FacilityGet->apiRequest();
            $decodeResponse = json_decode($facilityGetResponse->getBody(), true);

            // Error handling
            if($decodeResponse['ResultInfo']['Count'] === 0) {
                return response()->json($decodeResponse, 404);
            }

            $GetResponse = $FacilityGet->get_response();
            $response = $GetResponse->formatResponse();

            // Insert a request history
            $requestCountHistory = new RequestCountHistory();
            $requestCountHistory->setHistory(RequestCountHistory::TYPE_ID['getYahooLocalSearch'], $request->all()['userinfo']->id);

            return $this->normarize_multiple_response($response);
        }
        catch (BadResponseException $e)
        {
            $response = json_decode($e->getResponse()->getBody()->getContents(), true);
            return response()->json($response, $e->getResponse()->getStatusCode());
        }
    }
}
