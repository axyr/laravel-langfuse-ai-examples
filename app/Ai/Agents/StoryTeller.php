<?php

declare(strict_types=1);

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Promptable;

class StoryTeller implements Agent
{
    use Promptable;

    public function instructions(): string
    {
        return <<<'INSTRUCTIONS'
        You are a creative storyteller. Write engaging, vivid short stories
        based on the given prompt. Keep stories under 200 words. Use descriptive
        language and create compelling narratives with a clear beginning,
        middle, and end.
        INSTRUCTIONS;
    }
}
