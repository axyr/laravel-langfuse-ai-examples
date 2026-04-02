<?php

declare(strict_types=1);

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Promptable;

class Writer implements Agent
{
    use Promptable;

    public function __construct(
        private readonly string $researchNotes,
    ) {}

    public function instructions(): string
    {
        return <<<INSTRUCTIONS
        You are a skilled article writer. Using the research notes provided below,
        write a clear, engaging article. Structure it with an introduction,
        body paragraphs, and conclusion. Keep it concise but informative.

        Research notes:
        {$this->researchNotes}
        INSTRUCTIONS;
    }
}
