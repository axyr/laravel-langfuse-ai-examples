<?php

declare(strict_types=1);

use App\Ai\Agents\Researcher;
use App\Ai\Agents\Writer;
use Axyr\Langfuse\LangfuseFacade as Langfuse;

it('creates a single trace with spans for both agents', function () {
    $fake = Langfuse::fake();
    Researcher::fake(['- LLM observability tracks model performance\n- Costs can be monitored per query']);
    Writer::fake(['LLM observability has become essential for production AI applications.']);

    $this->artisan('example:multi-agent')->assertSuccessful();

    $fake->assertTraceCreated('researcher-writer-pipeline')
        ->assertSpanCreated('research-phase')
        ->assertSpanCreated('writing-phase');
});

it('prompts both agents in sequence', function () {
    Langfuse::fake();
    Researcher::fake(['- Key finding: observability reduces debugging time']);
    Writer::fake(['An article about LLM observability.']);

    $this->artisan('example:multi-agent')->assertSuccessful();

    Researcher::assertPrompted(fn($prompt) => $prompt->contains('observability'));
    Writer::assertPrompted(fn($prompt) => $prompt->contains('observability'));
});
