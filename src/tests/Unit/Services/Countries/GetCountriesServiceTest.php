<?php

namespace Tests\Unit\Services\Countries;

use Tests\SetUpTestCase;
use App\Services\Countries\GetCountriesService;
use App\Repositories\MCountries\MCountriesRepository;

class GetCountriesServiceTest extends SetUpTestCase
{
    /**
     * 正常系
     *
     * @test
     * @return void
     */
    public function should_return_country()
    {
        $atrs = ['id', 'name', 'country_code'];
        $service = (new GetCountriesService(new MCountriesRepository()))->get();
        foreach ($atrs as $attr) {
            $this->assertObjectHasAttribute($attr, $service);
        }
    }
}
