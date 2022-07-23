<?php

namespace Tests\Unit\Services\Strings;

use Tests\TestCase;
use App\Services\Strings\GenerateStringRandomlyService;

class GenerateStringRandomlyServiceTest extends TestCase
{
    /**
     * 正常系
     *
     * @test
     * @return void
     */
    public function should_return_one_character()
    {
        $service = (new GenerateStringRandomlyService())->get();
        $this->assertEquals(strlen($service), 1);
    }

    /**
     * 正常系
     *
     * @test
     * @return void
     */
    public function should_return_two_characters()
    {
        $service = (new GenerateStringRandomlyService())->get(2);
        $this->assertEquals(strlen($service), 2);
    }

    /**
     * 正常系
     *
     * @test
     * @return void
     */
    public function should_return_specified_string()
    {
        $service = (new GenerateStringRandomlyService('g'))->get(2);
        $this->assertEquals(strlen($service), 'gg');
    }
}
