<?php

namespace Tests\Feature\Api;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AiChatTest extends TestCase
{
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
}