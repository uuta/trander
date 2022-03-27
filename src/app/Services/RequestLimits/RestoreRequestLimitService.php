<?php

namespace App\Services\RequestLimits;

use App\Repositories\RequestLimits\RequestLimitRepository;

class RestoreRequestLimitService
{
    public $requestLimitRepository;

    public function __construct(
        RequestLimitRepository $requestLimitRepository
    ) {
        $this->requestLimitRepository = $requestLimitRepository;
    }

    public function handle()
    {
        $this->requestLimitRepository->restore();
    }
}
