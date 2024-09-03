<?php

namespace App\Services;

use External\Foo\Auth\AuthWS;
use External\Foo\Exceptions\AuthenticationFailedException;

class FooAuthStrategy implements AuthStrategyInterface
{
    public function authenticate(string $login, string $password): bool
    {
        $service = new AuthWS();

        try {
            $service->authenticate($login, $password);
            return true; // Authentication succeeded
        } catch (AuthenticationFailedException $e) {
            return false; // Authentication failed
        }
    }
}
