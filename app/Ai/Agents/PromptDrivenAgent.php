<?php

declare(strict_types=1);

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Promptable;

class PromptDrivenAgent implements Agent
{
    use Promptable;

    public function __construct(
        private readonly string $compiledPrompt,
    ) {}

    public function instructions(): string
    {
        return $this->compiledPrompt;
    }
}
