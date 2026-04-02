<?php

declare(strict_types=1);

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Promptable;

class Researcher implements Agent
{
    use Promptable;

    public function instructions(): string
    {
        return <<<'INSTRUCTIONS'
        You are a thorough researcher. Given a topic, produce well-organized
        bullet-point research notes covering the key facts, statistics, and
        insights. Focus on accuracy and breadth of coverage. Keep your
        response structured and scannable.
        INSTRUCTIONS;
    }
}
