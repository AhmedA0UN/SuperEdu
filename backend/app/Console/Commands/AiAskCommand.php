<?php

namespace App\Console\Commands;

use App\Services\Ai\ChatService;
use Illuminate\Console\Command;

class AiAskCommand extends Command
{
    protected $signature = 'ai:ask
                            {message* : Message a envoyer a l\'assistant AI}
                            {--assistant=superbot : Assistant cible (superbot, mentor, general)}
                            {--context= : Contexte JSON optionnel}';

    protected $description = 'Interroge la vraie IA configuree dans le backend';

    public function handle(ChatService $chatService): int
    {
        $message = trim(implode(' ', $this->argument('message')));
        $assistant = (string) ($this->option('assistant') ?: 'superbot');

        $context = [];
        $rawContext = $this->option('context');
        if (is_string($rawContext) && trim($rawContext) !== '') {
            $decoded = json_decode($rawContext, true);
            if (!is_array($decoded)) {
                $this->error('Option --context invalide: fournir un JSON objet, ex: {"subject":"Math"}.');

                return 1;
            }

            $context = $decoded;
        }

        $this->info(sprintf('Assistant: %s', $assistant));

        try {
            $result = $chatService->respond($message, $assistant, $context);
        } catch (\RuntimeException $exception) {
            $this->error($exception->getMessage());

            return 1;
        }

        $this->line('');
        $this->line((string) $result['reply']);
        $this->line('');
        $this->comment(sprintf(
            'provider=%s model=%s timestamp=%s',
            (string) ($result['provider'] ?? 'unknown'),
            (string) ($result['model'] ?? 'unknown'),
            (string) ($result['timestamp'] ?? now()->toIso8601String())
        ));

        return 0;
    }
}