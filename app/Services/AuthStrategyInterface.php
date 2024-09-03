<?php

namespace App\Services;

interface AuthStrategyInterface
{
public function authenticate(string $login, string $password): bool;
}
