<?php

declare(strict_types=1);

use App\Ai\Agents\StoryTeller;
use Axyr\Langfuse\LangfuseFacade as Langfuse;

it('runs the streaming command successfully', function () {
    Langfuse::fake();
    StoryTeller::fake(['Once upon a time, a Laravel application became sentient.']);

    $this->artisan('example:streaming')->assertSuccessful();
});

it('prompts the storyteller agent with the expected prompt', function () {
    Langfuse::fake();
    StoryTeller::fake(['The application started writing its own migrations.']);

    $this->artisan('example:streaming')->assertSuccessful();

    StoryTeller::assertPrompted(fn($prompt) => $prompt->contains('sentient'));
});
