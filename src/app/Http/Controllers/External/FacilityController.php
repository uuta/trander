<?php

namespace App\Http\Controllers\External;

use Illuminate\Http\Request;
use App\Http\Controllers\NormalizedController;
use App\Services\Facility\Get as FacilityGet;
use App\Http\Requests\Facility\GetRequest;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
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
            $FacilityGet->apiRequest();
            $GetResponse = $FacilityGet->get_response();
            $response = $GetResponse->formatResponse();

            // Insert a request history
            $requestCountHistory = new RequestCountHistory();
            $requestCountHistory->setHistory(RequestCountHistory::TYPE_ID['getYahooLocalSearch']);

            return $this->normarize_multiple_response($response);
        }
        catch (RequestException $e)
        {
            echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }
        }
    }
}
