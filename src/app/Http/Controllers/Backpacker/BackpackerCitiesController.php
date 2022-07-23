<?php

namespace App\Http\Controllers\Backpacker;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmptyResource;
use GuzzleHttp\Exception\BadResponseException;
use App\UseCases\Backpackers\BackpackerCitiesUseCase;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BackpackerCitiesController extends Controller
{
    public function index(Request $request)
    {
        try {
            return (new BackpackerCitiesUseCase($request))->handle($request->all()['userinfo']->id);
        } catch (ModelNotFoundException $e) {
            return response()->json((new EmptyResource([])), 404);
        } catch (BadResponseException $e) {
            return response()->json(json_decode($e->getResponse()->getBody()->getContents(), true), 500);
        }
    }
}
