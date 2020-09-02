<?php

namespace App\Http\Controllers\External;

use Illuminate\Http\Request;
use App\Http\Controllers\NormalizedController;
use GuzzleHttp\Exception\RequestException;
use App\Services\Wiki\GetCity as WikiCityGet;
use App\Http\Requests\Wiki\GetCityRequest;
use GuzzleHttp\Psr7;
use App\RequestCountHistory;

class WikiController extends NormalizedController
{
    public function city_index(GetCityRequest $request)
    {
        try
        {
            $this->normarize_request($request);

            // Request
            $FacilityGet = new WikiCityGet($request);
            $FacilityGet->apiRequest();
            $response = $FacilityGet->formatResponse();

            // Insert a request history
            $requestCountHistory = new RequestCountHistory();
            $requestCountHistory->setHistory(RequestCountHistory::TYPE_ID['getWikidata']);

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
