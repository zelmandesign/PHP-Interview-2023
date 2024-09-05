<?php

namespace App\Services\AuthService;

interface AuthStrategyInterface
{
public function authenticate(string $login, string $password): bool;
}
