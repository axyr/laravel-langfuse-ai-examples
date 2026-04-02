<?php

declare(strict_types=1);

use App\Ai\Agents\ResearchAssistant;
use Axyr\Langfuse\LangfuseFacade as Langfuse;

it('runs the agent with tools command successfully', function () {
    Langfuse::fake();
    ResearchAssistant::fake(['The population is approximately 17.5 million, divided by 12 equals about 1.46 million.']);

    $this->artisan('example:agent-with-tools')->assertSuccessful();
});

it('prompts the research assistant with the expected question', function () {
    Langfuse::fake();
    ResearchAssistant::fake(['The answer is approximately 1.46 million per province.']);

    $this->artisan('example:agent-with-tools')->assertSuccessful();

    ResearchAssistant::assertPrompted(fn($prompt) => $prompt->contains('Netherlands'));
});
