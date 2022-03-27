<?php

namespace App\Repositories\RequestLimits;

use App\Http\Models\RequestLimit;
use Illuminate\Database\Eloquent\Collection;

interface IRequestLimitRepository
{
    /**
     * @param string $unique_id
     * @return Collection
     */
    public function findById(string $unique_id): Collection;

    /**
     * @param Collection $requestLimit
     * @return void
     */
    public function decrement(Collection $res): void;

    /**
     * @return void
     */
    public function restore(): void;
}
