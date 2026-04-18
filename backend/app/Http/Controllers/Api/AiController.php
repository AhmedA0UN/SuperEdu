<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Ai\ChatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AiController extends Controller
{
    public function chat(Request $request, ChatService $chatService): JsonResponse
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'min:1', 'max:4000'],
            'assistant' => ['nullable', 'string', 'in:superbot,mentor,general'],
            'context' => ['nullable', 'array'],
        ]);

        try {
            $result = $chatService->respond(
                $data['message'],
                $data['assistant'] ?? 'general',
                $data['context'] ?? []
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