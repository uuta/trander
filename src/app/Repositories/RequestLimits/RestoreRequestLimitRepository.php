<?php

namespace App\Repositories\RequestLimits;

use App\Consts\TimeConst;
use Carbon\Carbon;
use App\Http\Models\RequestLimit;

/**
 * Restore request limit
 */
class RestoreRequestLimitRepository
{
    public function store(): void
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
