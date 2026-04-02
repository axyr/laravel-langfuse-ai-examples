<?php

declare(strict_types=1);

use App\Ai\Agents\Tutor;
use Axyr\Langfuse\LangfuseFacade as Langfuse;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates traces grouped by session for a multi-turn conversation', function () {
    $fake = Langfuse::fake();
    Tutor::fake([
        'Dependency injection is a design pattern where dependencies are provided to a class.',
        'In Laravel, type-hint dependencies in constructors and the service container resolves them.',
        'DI makes testing easier because you can swap real implementations with mocks.',
    ]);

    $this->artisan('example:conversation')->assertSuccessful();

    $fake->assertTraceCreated('conversation-turn-1')
        ->assertTraceCreated('conversation-turn-2')
        ->assertTraceCreated('conversation-turn-3');
});

it('prompts the tutor with three conversation turns', function () {
    Langfuse::fake();
    Tutor::fake([
        'DI provides dependencies from outside.',
        'Laravel uses the service container for this.',
        'In tests, you can inject fakes instead.',
    ]);

    $this->artisan('example:conversation')->assertSuccessful();

    Tutor::assertPrompted(fn($prompt) => $prompt->contains('dependency injection'));
    Tutor::assertPrompted(fn($prompt) => $prompt->contains('Laravel service container'));
    Tutor::assertPrompted(fn($prompt) => $prompt->contains('testing'));
});
