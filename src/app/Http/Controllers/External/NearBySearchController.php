<?php

namespace App\Http\Controllers\External;

use App\Http\Resources\EmptyResource;
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
