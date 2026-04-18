<?php

namespace App\Services\Ai;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class ChatService
{
    public function respond(string $message, string $assistant = 'general', array $context = [], array $history = []): array
    {
        $config = config('services.ai');
        $apiKey = $config['api_key'] ?? null;
        $baseUrl = rtrim((string) ($config['base_url'] ?? ''), '/');
        $model = (string) ($config['model'] ?? 'gpt-4o-mini');

        if (!$apiKey) {
            throw new RuntimeException('Le service AI n\'est pas configure. Definissez AI_API_KEY dans backend/.env.');
        }

        if ($baseUrl === '') {
            throw new RuntimeException('Le service AI n\'est pas configure. Definissez AI_BASE_URL dans backend/.env.');
        }

        $messages = [
            [
                'role' => 'system',
                'content' => $this->systemPrompt($assistant, $context),
            ],
        ];

        if (!empty($context)) {
            $messages[] = [
                'role' => 'system',
                'content' => 'Contexte applicatif: ' . json_encode($context, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            ];
        }

        foreach ($this->sanitizeHistory($history) as $item) {
            $messages[] = $item;
        }

        $messages[] = [
            'role' => 'user',
            'content' => $message,
        ];

        $response = Http::withToken($apiKey)
            ->acceptJson()
            ->timeout((int) ($config['timeout'] ?? 30))
            ->withHeaders(array_filter([
                'OpenAI-Organization' => $config['organization'] ?? null,
            ]))
            ->post($baseUrl . '/chat/completions', [
                'model' => $model,
                'messages' => $messages,
                'temperature' => 0.7,
            ]);

        $this->ensureSuccessfulResponse($response);

        $reply = data_get($response->json(), 'choices.0.message.content');
        if (!is_string($reply) || trim($reply) === '') {
            throw new RuntimeException('Le service AI a renvoye une reponse vide.');
        }

        return [
            'assistant' => $assistant,
            'provider' => $config['provider'] ?? 'openai',
            'model' => $model,
            'reply' => trim($reply),
            'timestamp' => now()->toIso8601String(),
        ];
    }

    private function systemPrompt(string $assistant, array $context = []): string
    {
        $basePrompt = 'Tu es un assistant pédagogique pour SuperEdu. Réponds en français, de manière claire, précise et utile. Structure les réponses avec des étapes courtes quand c\'est pertinent.';

        $assistantPrompt = match ($assistant) {
            'mentor' => 'Tu es Mentor IA. Tu aides un étudiant à réviser, s\'organiser, gérer son stress et clarifier son orientation. Donne des réponses bienveillantes, actionnables et adaptées au niveau de l\'étudiant.',
            'superbot' => 'Tu es SuperBot IA. Tu réponds aux questions sur les cours, les patterns de conception, le code, les quiz et la révision. Sois concis, pédagogique et concret.',
            default => 'Tu adaptes ton aide au besoin détecté dans le message de l\'utilisateur.',
        };

        if (!empty($context)) {
            $contextPrompt = 'Contexte utile: ' . json_encode($context, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

            return $basePrompt . ' ' . $assistantPrompt . ' ' . $contextPrompt;
        }

        return $basePrompt . ' ' . $assistantPrompt;
    }

    private function ensureSuccessfulResponse(Response $response): void
    {
        if ($response->successful()) {
            return;
        }

        $status = $response->status();
        $message = data_get($response->json(), 'error.message') ?: 'Le service AI est temporairement indisponible.';

        throw new RuntimeException(sprintf('%s (HTTP %d)', $message, $status));
    }

    private function sanitizeHistory(array $history): array
    {
        $normalized = [];

        foreach (array_slice($history, -10) as $item) {
            if (!is_array($item)) {
                continue;
            }

            $role = (string) ($item['role'] ?? '');
            $content = trim((string) ($item['content'] ?? ''));
            if ($content === '') {
                continue;
            }

            if (!in_array($role, ['user', 'assistant'], true)) {
                continue;
            }

            $normalized[] = [
                'role' => $role,
                'content' => mb_substr($content, 0, 4000),
            ];
        }

        return $normalized;
    }
}