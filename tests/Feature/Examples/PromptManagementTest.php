<?php

declare(strict_types=1);

use App\Ai\Agents\PromptDrivenAgent;
use Axyr\Langfuse\LangfuseFacade as Langfuse;

it('creates a prompt and a manually traced generation', function () {
    $fake = Langfuse::fake();
    PromptDrivenAgent::fake(['LLM observability helps monitor AI calls in production.']);

    $this->artisan('example:prompt-management')->assertSuccessful();

    $fake->assertPromptCreated('topic-explainer')
        ->assertTraceCreated('prompt-management-example');
});

it('prompts the agent with the compiled prompt instructions', function () {
    Langfuse::fake();
    PromptDrivenAgent::fake(['LLM observability is essential for production applications.']);

    $this->artisan('example:prompt-management')->assertSuccessful();

    PromptDrivenAgent::assertPrompted(fn($prompt) => $prompt->contains('observability'));
});
