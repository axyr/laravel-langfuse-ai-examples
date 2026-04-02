<?php

declare(strict_types=1);

use App\Ai\Agents\Summarizer;
use Axyr\Langfuse\LangfuseFacade as Langfuse;

it('creates a trace with scores attached', function () {
    $fake = Langfuse::fake();
    Summarizer::fake(['RAG enhances LLM responses by retrieving relevant documents.']);

    $this->artisan('example:scoring')->assertSuccessful();

    $fake->assertTraceCreated('scoring-example')
        ->assertScoreCreated('relevance')
        ->assertScoreCreated('conciseness')
        ->assertScoreCreated('quality');
});
