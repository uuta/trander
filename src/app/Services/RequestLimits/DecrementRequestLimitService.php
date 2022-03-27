<?php

namespace App\Services\RequestLimits;

use App\Repositories\RequestLimits\IRequestLimitRepository;

class DecrementRequestLimitService
{
    public $requestLimitRepository;

    public function __construct(
        IRequestLimitRepository $requestLimitRepository
    ) {
        $this->requestLimitRepository = $requestLimitRepository;
    }

    public function handle(string $unique_id)
    {
        $res = $this->requestLimitRepository->findById($unique_id);

        // Return if no record found
        if ($res->isEmpty()) {
            return;
        }

        $this->requestLimitRepository->decrement($res);
    }
}
