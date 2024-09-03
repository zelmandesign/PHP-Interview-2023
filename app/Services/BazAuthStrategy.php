<?php

namespace App\Services;

use External\Baz\Auth\Authenticator;
use External\Baz\Auth\Responses\Success;

class BazAuthStrategy implements AuthStrategyInterface
{
    public function authenticate(string $login, string $password): bool
    {
        $service = new Authenticator();
        $response = $service->auth($login, $password);
        return $response instanceof Success;
    }
}
