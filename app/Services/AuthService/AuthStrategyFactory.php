<?php

namespace App\Services\AuthService;

use External\Bar\Auth\LoginService;
use External\Baz\Auth\Authenticator;
use External\Foo\Auth\AuthWS;

class AuthStrategyFactory
{
    public function getAuthStrategy(string $login): ?AuthStrategyInterface
    {
        return match (true) {
            str_starts_with($login, 'BAR_') => new BarAuthStrategy(new LoginService()),
            str_starts_with($login, 'BAZ_') => new BazAuthStrategy(new Authenticator()),
            str_starts_with($login, 'FOO_') => new FooAuthStrategy(new AuthWS()),
            default => null,
        };
    }
}
