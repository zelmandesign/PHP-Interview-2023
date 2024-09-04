<?php

namespace App\Services;

use Firebase\JWT\JWT;

class AuthService
{
    private AuthStrategyFactory $strategyFactory;

    public function __construct(AuthStrategyFactory $strategyFactory)
    {
        $this->strategyFactory = $strategyFactory;
    }

    public function authenticate(string $login, string $password): ?string
    {
        $strategy = $this->strategyFactory->getAuthStrategy($login);

        if (!$strategy) {
            return null;
        }

        $authenticated = $strategy->authenticate($login, $password);

        if ($authenticated) {
            return $this->generateJwtToken($login, $this->strategyFactory->getPrefix($login));
        }

        return null;
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
