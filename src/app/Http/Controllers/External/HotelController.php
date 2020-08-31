<?php

namespace App\Http\Controllers\External;

use Illuminate\Http\Request;
use App\Http\Controllers\NormalizedController;
use App\Http\Requests\Hotel\GetRequest;
use App\Services\Hotel\Get as HotelGet;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use App\RequestCountHistory;

class HotelController extends NormalizedController
{
    public function index(GetRequest $request)
    {
        try
        {
            $this->normarize_request($request);

            // Request
            $FacilityGet = new HotelGet($request);
            $FacilityGet->apiRequest();
            $response = $FacilityGet->formatResponse();

            // Insert a request history
            $requestCountHistory = new RequestCountHistory();
            $requestCountHistory->setHistory(RequestCountHistory::TYPE_ID['getSimpleHotelSearch']);

            return $this->normarize_response($response);
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
