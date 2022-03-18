<?php

namespace App\UseCases\Cities;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\Cities\IndexRequest;

interface ICitiesIndexUseCase
{
    /**
     * @param CitiesIndexInputData $inputData
     * @return JsonResponse
     * @abstract
     * @access public
     */
    public function handle(IndexRequest $request): JsonResponse;
}
