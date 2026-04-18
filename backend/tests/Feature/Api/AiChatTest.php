<?php

namespace Tests\Feature\Api;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AiChatTest extends TestCase
{
    public function test_ai_health_endpoint_exposes_configuration_status(): void
    {
        config()->set('services.ai.api_key', 'test-key');
        config()->set('services.ai.base_url', 'https://example.test/v1');
        config()->set('services.ai.model', 'test-model');

        $response = $this->getJson('/api/ai/health');

        $response->assertOk();
        $response->assertJsonPath('status', 'configured');
        $response->assertJsonPath('configured.api_key', true);
        $response->assertJsonPath('configured.base_url', true);
        $response->assertJsonPath('configured.model', true);
    }

    public function test_ai_chat_returns_provider_reply(): void
    {
        config()->set('services.ai.api_key', 'test-key');
        config()->set('services.ai.base_url', 'https://example.test/v1');
        config()->set('services.ai.model', 'test-model');

        Http::fake([
            'https://example.test/v1/chat/completions' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => 'Voici une reponse generée par le vrai provider.',
                        ],
                    ],
                ],
            ], 200),
        ]);

        $response = $this->postJson('/api/ai/chat', [
            'assistant' => 'mentor',
            'message' => 'Je veux un plan de révision',
            'context' => [
                'subject' => 'Mathématiques',
            ],
        ]);

        $response->assertOk();
        $response->assertJsonPath('assistant', 'mentor');
        $response->assertJsonPath('provider', 'openai');
        $response->assertJsonPath('model', 'test-model');
        $response->assertJsonPath('reply', 'Voici une reponse generée par le vrai provider.');

        Http::assertSent(function ($request) {
            $payload = $request->data();

            return $request->url() === 'https://example.test/v1/chat/completions'
                && $payload['model'] === 'test-model'
                && $payload['messages'][0]['role'] === 'system'
                && str_contains($payload['messages'][0]['content'], 'Mentor IA')
                && $payload['messages'][2]['content'] === 'Je veux un plan de révision';
        });
    }

    public function test_ai_chat_returns_validation_error_for_empty_message(): void
    {
        $response = $this->postJson('/api/ai/chat', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['message']);
    }

    public function test_ai_chat_forwards_history_messages(): void
    {
        config()->set('services.ai.api_key', 'test-key');
        config()->set('services.ai.base_url', 'https://example.test/v1');

        Http::fake([
            'https://example.test/v1/chat/completions' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => 'Réponse avec historique.',
                        ],
                    ],
                ],
            ], 200),
        ]);

        $response = $this->postJson('/api/ai/chat', [
            'assistant' => 'superbot',
            'message' => 'Continue la conversation',
            'history' => [
                ['role' => 'user', 'content' => 'Bonjour'],
                ['role' => 'assistant', 'content' => 'Salut, comment puis-je aider ?'],
            ],
        ]);

        $response->assertOk();
        $response->assertJsonPath('reply', 'Réponse avec historique.');

        Http::assertSent(function ($request) {
            $messages = $request->data()['messages'] ?? [];

            return collect($messages)->contains(fn ($message) => ($message['role'] ?? '') === 'user' && ($message['content'] ?? '') === 'Bonjour')
                && collect($messages)->contains(fn ($message) => ($message['role'] ?? '') === 'assistant' && ($message['content'] ?? '') === 'Salut, comment puis-je aider ?')
                && collect($messages)->contains(fn ($message) => ($message['role'] ?? '') === 'user' && ($message['content'] ?? '') === 'Continue la conversation');
        });
    }
}