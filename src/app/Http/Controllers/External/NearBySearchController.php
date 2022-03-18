<?php

namespace App\Http\Controllers\External;

use App\Http\Models\GooglePlaceId;
use App\Http\Resources\EmptyResource;
use App\Http\Models\RequestCountHistory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\NearBySearch\GetRequest;
use GuzzleHttp\Exception\BadResponseException;
use App\Http\Resources\NearBySearch\IndexResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\UseCases\NearBySearch\NearBySearchGetUseCase;

class NearBySearchController extends Controller
{
    public function index(GetRequest $request)
    {
        DB::beginTransaction();
        try {
            // Request
            $res = (new NearBySearchGetUseCase($request))->handle();

            // Insert into google_place_ids
            GooglePlaceId::insert_information($res);

            // Insert a request history
            (new RequestCountHistory())->setHistory(RequestCountHistory::TYPE_ID['getNearBySearch'], $request->all()['userinfo']->id);

            DB::commit();
            return (new IndexResource($res));
        } catch (ModelNotFoundException $e) {
            DB::commit();
            return (new EmptyResource([]));
        } catch (BadResponseException $e) {
            DB::rollBack();
            $response = json_decode($e->getResponse()->getBody()->getContents(), true);
            return response()->json($response, $e->getResponse()->getStatusCode());
        }
    }
}
