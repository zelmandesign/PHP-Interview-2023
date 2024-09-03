<?php

namespace App\Services;

use Firebase\JWT\JWT;

class AuthService
{
    public function authenticate(string $login, string $password): ?string
    {
        $strategy = $this->getAuthStrategy($login);

        if (!$strategy) {
            return null;
        }

        $authenticated = $strategy->authenticate($login, $password);

        if ($authenticated) {
            return $this->generateJwtToken($login, $this->getPrefix($login));
        }

        return null;
    }

    private function getPrefix(string $login): ?string
    {
        // Extract prefix based on known patterns
        if (str_starts_with($login, 'BAR_')) {
            return 'BAR';
        } elseif (str_starts_with($login, 'BAZ_')) {
            return 'BAZ';
        } elseif (str_starts_with($login, 'FOO_')) {
            return 'FOO';
        }

        return null;
    }

    private function getAuthStrategy(string $login): ?AuthStrategyInterface
    {
        $prefix = $this->getPrefix($login);

        $strategies = [
            'BAR' => new BarAuthStrategy(),
            'BAZ' => new BazAuthStrategy(),
            'FOO' => new FooAuthStrategy(),
        ];

        return $strategies[$prefix] ?? null;
    }

    private function generateJwtToken(string $login, string $context): string
    {
        $payload = [
            'login' => $login,
            'context' => $context,
            'iat' => time(),
        ];

        return JWT::encode($payload, 'your_secret_key', 'HS256');
    }
}
