<?php

namespace App\UseCases\RequestCountHistorys;

use App\Repositories\RequestCountHistorys\RequestCountHistoryRepository;

class RequestCountHistoryStoreUseCase
{
    private $repository;

    public function __construct(RequestCountHistoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(int $user_id, int $type_id): void
    {
        $this->repository->store($user_id, $type_id);
    }
}
