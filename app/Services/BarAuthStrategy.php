<?php

namespace App\Services;

use External\Bar\Auth\LoginService;

class BarAuthStrategy implements AuthStrategyInterface
{
    protected LoginService $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function authenticate(string $login, string $password): bool
    {
        return $this->loginService->login($login, $password);
    }
}
