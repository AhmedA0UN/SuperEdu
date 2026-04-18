<?php

namespace Tests\Feature\Console;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AiAskCommandTest extends TestCase
{
    public function test_ai_ask_command_calls_provider_and_returns_success(): void
    {
        config()->set('services.ai.api_key', 'test-key');
        config()->set('services.ai.base_url', 'https://example.test/v1');
        config()->set('services.ai.model', 'test-model');

        Http::fake([
            'https://example.test/v1/chat/completions' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => 'Reponse AI en mode CLI.',
                        ],
                    ],
                ],
            ], 200),
        ]);

        $this->artisan('ai:ask', [
            'message' => ['Explique', 'Observer'],
            '--assistant' => 'superbot',
            '--context' => '{"subject":"design-patterns"}',
        ])->assertExitCode(0);

        Http::assertSent(function ($request) {
            $payload = $request->data();

            return $request->url() === 'https://example.test/v1/chat/completions'
                && $payload['model'] === 'test-model'
                && $payload['messages'][2]['content'] === 'Explique Observer';
        });
    }

    public function test_ai_ask_command_fails_on_invalid_context_json(): void
    {
        $this->artisan('ai:ask', [
            'message' => ['Bonjour'],
            '--context' => '{invalid',
        ])->assertExitCode(1);
    }
}