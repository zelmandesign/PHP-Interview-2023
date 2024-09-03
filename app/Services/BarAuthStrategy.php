<?php

namespace App\Services;

use External\Bar\Auth\LoginService;

class BarAuthStrategy implements AuthStrategyInterface
{
    public function authenticate(string $login, string $password): bool
    {
        $service = new LoginService();
        return $service->login($login, $password);
    }
}
