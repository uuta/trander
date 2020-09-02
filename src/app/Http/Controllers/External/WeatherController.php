<?php

namespace App\Http\Controllers\External;

use Illuminate\Http\Request;
use App\Http\Controllers\NormalizedController;
use App\Http\Requests\Weather\GetRequest;
use GuzzleHttp\Exception\RequestException;
use App\Services\Weather\Get as WeatherGet;
use GuzzleHttp\Psr7;
use App\RequestCountHistory;

class WeatherController extends NormalizedController
{
    public function index(GetRequest $request)
    {
        try
        {
            $this->normarize_request($request);

            // Request
            $FacilityGet = new WeatherGet($request);
            $FacilityGet->apiRequest();
            $response = $FacilityGet->formatResponse();

            // Insert a request history
            $requestCountHistory = new RequestCountHistory();
            $requestCountHistory->setHistory(RequestCountHistory::TYPE_ID['getCurrentWeather']);

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
