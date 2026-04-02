<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Ai\Agents\ResearchAssistant;
use App\Console\Commands\Concerns\FormatsExampleOutput;
use Axyr\Langfuse\LangfuseFacade as Langfuse;
use Illuminate\Console\Command;

class AgentWithToolsCommand extends Command
{
    use FormatsExampleOutput;

    protected $signature = 'example:agent-with-tools';

    protected $description = 'Example 2: Agent with tools - tool calls appear as Langfuse spans';

    public function handle(): int
    {
        $this->header(
            'Example 2: Agent with Tools',
            'Tool calls automatically appear as spans in Langfuse.',
        );

        $question = 'What is the population of the Netherlands and what is 17.5 million divided by 12 provinces?';

        $this->line("  <fg=gray>Question: {$question}</>");
        $this->line('  <fg=gray>Prompting ResearchAssistant agent...</>');

        $response = ResearchAssistant::make()->prompt($question);

        $this->newLine();
        $this->line("  <fg=white>{$response}</>");

        Langfuse::flush();

        $this->langfuseReminder();

        return self::SUCCESS;
    }
}
