<?php

namespace Tests;

use App\Http\Middleware\JWTMiddleware;
use App\Http\Middleware\FriendOwner;
use App\Http\Middleware\HistoryOwner;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        app('router')->aliasMiddleware('jwt', JWTMiddleware::class);
        app('router')->aliasMiddleware('friendOwner', FriendOwner::class);
        app('router')->aliasMiddleware("historyOwner", HistoryOwner::class);
    }
}
