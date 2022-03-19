<?php

namespace App\Repositories\RequestCountHistorys;

use Illuminate\Support\Facades\DB;
use App\Repositories\RequestCountHistorys\IRequestCountHistoryRepository;

class RequestCountHistoryRepository implements IRequestCountHistoryRepository
{
    protected $table = 'request_count_historys';

    public function store(int $user_id, int $type_id): void
    {
        DB::table('request_count_historys')->insert(
            [
                'user_id' => $user_id,
                'type_id' => $type_id,
            ]
        );
    }
}
