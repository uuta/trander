<?php

namespace App\Http\Controllers\External;

use App\Http\Controllers\Controller;
use App\Http\Resources\EmptyResource;
use App\Http\Models\RequestCountHistory;
use App\Http\Requests\GeoDBCitiesApiRequest;
use GuzzleHttp\Exception\BadResponseException;
use App\Http\Requests\GeoDBCities\GetIdRequest;
use App\Repositories\Directions\DirectionRepository;
use App\Services\GeoDBCities\GetId as GeoDBCitiesGetId;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\GeoDBCities\GeoDBCitiesRequestResource;
use App\UseCases\GeoDBCities\Request\GeoDBCitiesRequestUseCase;
use App\Services\RequestApis\GeoDBCities\GeoDBCitiesRequestApiService;

class GeoDBCitiesController extends Controller
{
    public function request(
        GeoDBCitiesApiRequest $request,
        GeoDBCitiesRequestApiService $geoDBCitiesRequestApiService,
        DirectionRepository $directionRepository
    ) {
        try {
            $data = (new GeoDBCitiesRequestUseCase($request, $geoDBCitiesRequestApiService, $directionRepository))->handle();

            // Insert a request history
            (new RequestCountHistory())->setHistory(RequestCountHistory::TYPE_ID['getGeoDbCities'], $request->all()['userinfo']->id);

            return (new GeoDBCitiesRequestResource($data));
        } catch (ModelNotFoundException $e) {
            return response()->json((new EmptyResource([])), 204);
        } catch (BadResponseException $e) {
            $response = json_decode($e->getResponse()->getBody()->getContents(), true);
            return response()->json($response, 500);
        }
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
            (new RequestCountHistory())->setHistory(RequestCountHistory::TYPE_ID['getGeoDbCitiesId'], $request->all()['userinfo']->id);

            return $response;
        } catch (BadResponseException $e) {
            $response = json_decode($e->getResponse()->getBody()->getContents(), true);
            return response()->json($response, $e->getResponse()->getStatusCode());
        }
    }
}
