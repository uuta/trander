<?php

namespace App\Services\Dates;

use Carbon\Carbon;
use Carbon\CarbonInterval;

class DiffDateService
{
    private $former;
    private $latter;

    public function __construct(Carbon $former, Carbon $latter)
    {
        $this->former = $former;
        $this->latter = $latter;
    }

    /**
     * Get all of diff with short form
     *
     * @return string
     */
    public function getDiffAll(): string
    {
        $value = $this->former->diffInSeconds($this->latter);
        return CarbonInterval::seconds($value)->cascade()->forHumans(true);
    }
}
