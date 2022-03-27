<?php

namespace App\Repositories\RequestLimits;

use Carbon\Carbon;
use App\Consts\TimeConst;
use App\Http\Models\RequestLimit;

class RequestLimitRepository
{
    /**
     * Decrement request limit
     *
     * @param string $unique_id
     */
    public function decrement(string $unique_id): void
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

    /**
     * Restore request limit
     *
     * @return void
     */
    public function restore(): void
    {
        $where_date = (new Carbon(RequestLimit::RESTORE_DATE))->format(TimeConst::DATETIME);

        RequestLimit::where([
            ['request_limit', '<', RequestLimit::DEFAULT_LIMIT],
            ['first_request_at', '<', $where_date],
        ])->update([
            'request_limit' => RequestLimit::DEFAULT_LIMIT,
            'first_request_at' => Carbon::now()->format(TimeConst::DATETIME),
        ]);
    }
}
