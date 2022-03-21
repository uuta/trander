<?php

namespace App\Repositories\RequestLimits;

use App\Http\Models\RequestLimit;

class ConsumeRequestLimitRepository
{
    public function store(string $unique_id)
    {
        $res = RequestLimit::whereHas('user', function ($query) use ($unique_id) {
            $query->where('unique_id', $unique_id);
        })->get();

        // Return if no record found
        if ($res->isEmpty()) {
            return;
        }

        // Decrement
        $request_limit = $res[0]->request_limit;
        if (0 < $request_limit) {
            $res[0]->request_limit = --$request_limit;
            $res[0]->save();
        }
    }
}
