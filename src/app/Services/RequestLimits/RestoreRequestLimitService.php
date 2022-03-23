<?php

namespace App\Services\RequestLimits;

use App\Repositories\RequestLimits\RestoreRequestLimitRepository;

class RestoreRequestLimitService
{
    public $restoreRequestLimitRepository;

    public function __construct(
        RestoreRequestLimitRepository $restoreRequestLimitRepository
    ) {
        $this->restoreRequestLimitRepository = $restoreRequestLimitRepository;
    }

    public function handle()
    {
        $this->restoreRequestLimitRepository->store();
    }
}
