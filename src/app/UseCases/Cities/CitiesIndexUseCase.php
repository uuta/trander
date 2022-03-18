<?php

namespace App\UseCases\Cities;

use App\Http\Requests\Cities\IndexRequest;
use App\UseCases\Cities\ICitiesIndexUseCase;

class CitiesIndexUseCase implements ICitiesIndexUseCase
{
    public function handle(IndexRequest $request): JsonResponse
    {
    }
}
