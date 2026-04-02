<?php

declare(strict_types=1);

use App\Ai\Agents\SentimentAnalyzer;
use Axyr\Langfuse\LangfuseFacade as Langfuse;

it('runs the structured output command successfully', function () {
    Langfuse::fake();
    SentimentAnalyzer::fake([
        ['sentiment' => 'positive', 'confidence' => 0.95, 'key_phrases' => ['exceeded expectations'], 'summary' => 'Very positive review'],
        ['sentiment' => 'negative', 'confidence' => 0.92, 'key_phrases' => ['terrible experience'], 'summary' => 'Very negative review'],
        ['sentiment' => 'neutral', 'confidence' => 0.78, 'key_phrases' => ['works as described'], 'summary' => 'Neutral review'],
    ]);

    $this->artisan('example:structured-output')->assertSuccessful();
});

it('prompts the sentiment analyzer for each review', function () {
    Langfuse::fake();
    SentimentAnalyzer::fake([
        ['sentiment' => 'positive', 'confidence' => 0.95, 'key_phrases' => ['exceeded expectations'], 'summary' => 'Very positive'],
        ['sentiment' => 'negative', 'confidence' => 0.92, 'key_phrases' => ['terrible'], 'summary' => 'Very negative'],
        ['sentiment' => 'neutral', 'confidence' => 0.78, 'key_phrases' => ['works'], 'summary' => 'Neutral'],
    ]);

    $this->artisan('example:structured-output')->assertSuccessful();

    SentimentAnalyzer::assertPrompted(fn($prompt) => $prompt->contains('exceeded'));
    SentimentAnalyzer::assertPrompted(fn($prompt) => $prompt->contains('Terrible'));
    SentimentAnalyzer::assertPrompted(fn($prompt) => $prompt->contains('works as described'));
});
