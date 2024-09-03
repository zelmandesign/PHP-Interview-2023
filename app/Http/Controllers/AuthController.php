<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request): JsonResponse
    {
        $login = $request->input('login');
        $password = $request->input('password');

        $token = $this->authService->authenticate($login, $password);

        if ($token) {
            return response()->json(['status' => 'success', 'token' => $token]);
        }

        return response()->json(['status' => 'failure']);
    }
}
