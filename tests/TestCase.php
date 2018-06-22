<?php

namespace Tests;

use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function login ($user)
    {
        $token=JWTAuth::fromUser($user);
        return $token;
    }
}
