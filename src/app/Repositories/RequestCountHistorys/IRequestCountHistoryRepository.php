<?php

namespace App\Repositories\RequestCountHistorys;

interface IRequestCountHistoryRepository
{
    /**
     * @param User_id $user_id
     * @param Type_id $type_id
     * @return void
     */
    public function store(int $user_id, int $type_id): void;
}
