<?php

namespace App\Services\Countries;

use stdClass;
use Illuminate\Support\Collection;
use App\Repositories\MCountries\IMCountriesRepository;

class GetCountriesService
{
    private $repository;
    private $countries;

    public function __construct(IMCountriesRepository $repository)
    {
        $this->repository = $repository;

        $this->_getCountryId();
    }

    private function _getCountryId(): void
    {
        $this->countries = $this->repository->getAll();
    }

    public function get(): stdClass
    {
        return $this->countries->random();
    }
}
