<?php

namespace App\Repositories\MCountries;

use Illuminate\Support\Collection;

interface IMCountriesRepository
{
    public function getAll(): Collection;
}
