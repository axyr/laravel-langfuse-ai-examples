<?php

declare(strict_types=1);

namespace App\Ai\Agents;

use App\Ai\Tools\Calculator;
use App\Ai\Tools\SearchWeb;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Promptable;

class ResearchAssistant implements Agent, HasTools
{
    use Promptable;

    public function instructions(): string
    {
        return <<<'INSTRUCTIONS'
        You are a research assistant with access to web search and a calculator.
        Use the search tool to find information and the calculator for any
        mathematical computations. Provide well-researched, accurate answers.
        INSTRUCTIONS;
    }

    public function tools(): array
    {
        return [
            new SearchWeb(),
            new Calculator(),
        ];
    }
}
