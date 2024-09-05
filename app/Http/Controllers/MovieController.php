<?php

namespace App\Http\Controllers;

use App\Services\MovieService\MovieService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    private MovieService $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function getTitles(Request $request): JsonResponse
    {
        try {
            $titles = $this->movieService->getAllTitles();
            return response()->json($titles);
        } catch (Exception $e) {
            return response()->json(['status' => 'failure'], 500);
        }
    }
}
