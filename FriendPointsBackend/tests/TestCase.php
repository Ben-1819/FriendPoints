<?php

namespace Tests;

use App\Http\Middleware\JWTMiddleware;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        app('router')->aliasMiddleware('jwt', JWTMiddleware::class);
    }
}
