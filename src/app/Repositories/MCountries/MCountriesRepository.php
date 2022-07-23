<?php

namespace App\Repositories\MCountries;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MCountriesRepository implements IMCountriesRepository
{
    protected $table = 'm_countries';

    public function getAll(): Collection
    {
        return DB::table($this->table)->get();
    }
}
