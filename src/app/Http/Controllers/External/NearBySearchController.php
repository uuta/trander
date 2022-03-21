<?php

namespace App\Http\Controllers\External;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmptyResource;
use App\Http\Models\RequestCountHistory;
use App\Http\Requests\NearBySearch\GetRequest;
use GuzzleHttp\Exception\BadResponseException;
use App\Services\Facades\GenerateLocationService;
use App\Http\Resources\NearBySearch\IndexResource;
use App\Services\Contents\GetContentRandomlyService;
use App\UseCases\NearBySearch\NearBySearchGetUseCase;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\RequestApis\NearBySearches\NearBySearchRequestApiService;

class NearBySearchController extends Controller
{
    public function index(
        GetRequest $request,
        NearBySearchRequestApiService $nearBySearchRequestApiService,
        GenerateLocationService $generateLocationService,
        GetContentRandomlyService $getContentRandomlyService
    ) {
        DB::beginTransaction();
        try {
            // Request
            $res = (new NearBySearchGetUseCase(
                $request,
                $generateLocationService,
                $nearBySearchRequestApiService,
                $getContentRandomlyService

            )
            )->handle(
                $request->all()['userinfo']->id,
                RequestCountHistory::TYPE_ID['getNearBySearch']
            );

            DB::commit();
            return (new IndexResource($res));
        } catch (ModelNotFoundException $e) {
            DB::commit();
            return (new EmptyResource([]));
        } catch (BadResponseException $e) {
            DB::rollBack();
            return response()->json(json_decode($e->getResponse()->getBody()->getContents(), true), 500);
        }
    }
}
