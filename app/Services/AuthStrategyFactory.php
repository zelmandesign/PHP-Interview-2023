<?php

namespace App\Services;

use External\Bar\Auth\LoginService;
use External\Baz\Auth\Authenticator;
use External\Foo\Auth\AuthWS;

class AuthStrategyFactory
{
    public function getAuthStrategy(string $login): ?AuthStrategyInterface
    {
        $prefix = $this->getPrefix($login);

        return match ($prefix) {
            'BAR' => new BarAuthStrategy(new LoginService()),
            'BAZ' => new BazAuthStrategy(new Authenticator()),
            'FOO' => new FooAuthStrategy(new AuthWS()),
            default => null,
        };
    }

    public function getPrefix(string $login): ?string
    {
        $prefixMap = [
            'BAR' => 'BAR_',
            'BAZ' => 'BAZ_',
            'FOO' => 'FOO_',
        ];

        foreach ($prefixMap as $prefix => $pattern) {
            if (str_starts_with($login, $pattern)) {
                return $prefix;
            }
        }

        return null;
    }
}
