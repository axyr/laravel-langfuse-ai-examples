<?php

declare(strict_types=1);

use App\Ai\Agents\Summarizer;
use Axyr\Langfuse\LangfuseFacade as Langfuse;

it('runs the basic agent command successfully', function () {
    Langfuse::fake();
    Summarizer::fake(['A concise summary of the text.']);

    $this->artisan('example:basic-agent')->assertSuccessful();
});

it('prompts the summarizer agent with sample text', function () {
    Langfuse::fake();
    Summarizer::fake(['A concise summary of the text.']);

    $this->artisan('example:basic-agent')->assertSuccessful();

    Summarizer::assertPrompted(fn($prompt) => $prompt->contains('Laravel'));
});
