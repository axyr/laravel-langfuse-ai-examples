<?php

declare(strict_types=1);

namespace App\Ai\Agents;

use Laravel\Ai\Concerns\RemembersConversations;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Promptable;

class Tutor implements Agent, Conversational
{
    use Promptable;
    use RemembersConversations;

    public function instructions(): string
    {
        return <<<'INSTRUCTIONS'
        You are a patient, knowledgeable tutor. Explain concepts clearly and
        build on previous messages in the conversation. Ask follow-up questions
        to check understanding. Adapt your explanations based on the student's
        level of knowledge shown in prior exchanges.
        INSTRUCTIONS;
    }
}
