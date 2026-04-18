<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Ai\ChatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AiController extends Controller
{
    public function health(): JsonResponse
    {
        $apiKey = (string) config('services.ai.api_key', '');

        return response()->json([
            'service' => config('app.name', 'SuperEdu') . '-ai',
            'status' => $apiKey !== '' ? 'configured' : 'missing-configuration',
            'configured' => [
                'api_key' => $apiKey !== '',
                'base_url' => (string) config('services.ai.base_url', '') !== '',
                'model' => (string) config('services.ai.model', '') !== '',
            ],
            'timestamp' => now()->toIso8601String(),
        ]);
    }

    public function chat(Request $request, ChatService $chatService): JsonResponse
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'min:1', 'max:4000'],
            'assistant' => ['nullable', 'string', 'in:superbot,mentor,general'],
            'context' => ['nullable', 'array'],
            'history' => ['nullable', 'array', 'max:20'],
            'history.*.role' => ['required_with:history', 'string', 'in:user,assistant'],
            'history.*.content' => ['required_with:history', 'string', 'max:4000'],
        ]);

        try {
            $result = $chatService->respond(
                $data['message'],
                $data['assistant'] ?? 'general',
                $data['context'] ?? [],
                $data['history'] ?? []
            );

            return response()->json($result);
        } catch (\RuntimeException $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'status' => 'unavailable',
            ], 503);
        }
    }
}