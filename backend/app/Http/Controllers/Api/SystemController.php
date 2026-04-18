<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class SystemController extends Controller
{
    public function health(): JsonResponse
    {
        return response()->json([
            'service' => config('app.name', 'SuperEdu'),
            'status' => 'ok',
            'environment' => app()->environment(),
            'php' => PHP_VERSION,
            'laravel' => app()->version(),
            'timestamp' => now()->toIso8601String(),
        ]);
    }

    public function status(): JsonResponse
    {
        return response()->json([
            'service' => config('app.name', 'SuperEdu'),
            'status' => 'ok',
            'environment' => app()->environment(),
            'php' => PHP_VERSION,
            'laravel' => app()->version(),
            'routes' => [
                'health' => url('/api/health'),
                'status' => url('/api/status'),
            ],
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}