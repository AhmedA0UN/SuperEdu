<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class SystemStatusTest extends TestCase
{
    public function test_health_endpoint_returns_ok(): void
    {
        $response = $this->getJson('/api/health');

        $response->assertOk();
        $response->assertJsonStructure([
            'service',
            'status',
            'environment',
            'php',
            'laravel',
            'timestamp',
        ]);
        $response->assertJsonPath('status', 'ok');
    }

    public function test_status_endpoint_returns_service_metadata(): void
    {
        $response = $this->getJson('/api/status');

        $response->assertOk();
        $response->assertJsonStructure([
            'service',
            'status',
            'environment',
            'php',
            'laravel',
            'routes' => [
                'health',
                'status',
            ],
            'timestamp',
        ]);
        $response->assertJsonPath('status', 'ok');
    }
}