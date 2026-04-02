<?php

declare(strict_types=1);

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Promptable;

class Summarizer implements Agent
{
    use Promptable;

    public function instructions(): string
    {
        return <<<'INSTRUCTIONS'
        You are a concise summarizer. Given any text, produce a clear summary
        that captures the key points in 2-3 sentences. Focus on the most
        important information and omit unnecessary details.
        INSTRUCTIONS;
    }
}
