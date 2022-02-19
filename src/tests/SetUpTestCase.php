<?php

namespace Tests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SetUpTestCase extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }
}
