<?php

namespace App\Http\Controllers;

use App\Services\AuthService\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
        $validator = Validator::make($request->all(), [
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'errors' => $validator->errors(),
            ], 422);
        }

        $login = $request->input('login');
        $password = $request->input('password');

        $token = $this->authService->authenticate($login, $password);

        if ($token) {
            return response()->json(['status' => 'success', 'token' => $token]);
        }

        return response()->json(['status' => 'failure'], 401);
    }
}
