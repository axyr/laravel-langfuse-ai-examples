<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Ai\Agents\Tutor;
use App\Console\Commands\Concerns\FormatsExampleOutput;
use Axyr\Langfuse\Dto\TraceBody;
use Axyr\Langfuse\LangfuseFacade as Langfuse;
use Illuminate\Console\Command;

class ConversationCommand extends Command
{
    use FormatsExampleOutput;

    protected $signature = 'example:conversation';

    protected $description = 'Example 9: Multi-turn conversation with Langfuse session grouping';

    public function handle(): int
    {
        $this->header(
            'Example 9: Conversation',
            'Multi-turn conversation with session grouping in Langfuse.',
        );

        $sessionId = 'session-' . substr(md5((string) time()), 0, 8);
        $user = (object) ['id' => 'student-1', 'name' => 'Student'];

        $turns = [
            'What is dependency injection and why should I use it?',
            'Can you give me a practical example using Laravel service container?',
            'How does this relate to testing? Can you show how DI makes testing easier?',
        ];

        $conversationId = null;

        foreach ($turns as $index => $question) {
            $turnNumber = $index + 1;
            $this->line("  <fg=gray>Turn {$turnNumber}: {$question}</>");

            // Create a trace per turn, linked by sessionId
            $trace = Langfuse::trace(new TraceBody(
                name: "conversation-turn-{$turnNumber}",
                sessionId: $sessionId,
                userId: $user->id,
                input: $question,
                metadata: ['turn' => $turnNumber],
            ));
            Langfuse::setCurrentTrace($trace);

            $tutor = new Tutor();

            if ($conversationId === null) {
                $tutor = $tutor->forUser($user);
            }

            if ($conversationId !== null) {
                $tutor = $tutor->continue($conversationId, as: $user);
            }

            $response = $tutor->prompt($question);
            $conversationId = $response->conversationId ?? $conversationId;

            $trace->update(new TraceBody(output: (string) $response));

            $this->newLine();
            $this->line("  <fg=white>Tutor: {$response}</>");
            $this->newLine();
        }

        $this->line("  <fg=gray>Session ID: {$sessionId} - all 3 turns are grouped in Langfuse.</>");

        Langfuse::flush();

        $this->langfuseReminder();

        return self::SUCCESS;
    }
}
