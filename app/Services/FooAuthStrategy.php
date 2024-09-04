<?php

namespace App\Services;

use External\Foo\Auth\AuthWS;
use External\Foo\Exceptions\AuthenticationFailedException;

class FooAuthStrategy implements AuthStrategyInterface
{
    protected AuthWS $authService;

    public function __construct(AuthWS $authService)
    {
        $this->authService = $authService;
    }

    public function authenticate(string $login, string $password): bool
    {
        try {
            $this->authService->authenticate($login, $password);
            return true;
        } catch (AuthenticationFailedException $e) {
            return false;
        }
    }
}
