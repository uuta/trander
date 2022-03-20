<?php

namespace App\UseCases\RequestCountHistorys;

use App\Repositories\RequestCountHistorys\RequestCountHistoryRepository;

class RequestCountHistoryStoreUseCase
{
    private $repository;

    public function __construct(RequestCountHistoryRepository $repository, int $type_id, int $user_id)
    {
        $this->repository = $repository;
        $this->type_id = $type_id;
        $this->user_id = $user_id;
    }

    public function handle()
    {
        $this->repository->store($this->user_id, $this->type_id);
    }
}
