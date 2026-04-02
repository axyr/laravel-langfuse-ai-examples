<?php

declare(strict_types=1);

namespace App\Ai\Agents;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Promptable;

class SentimentAnalyzer implements Agent, HasStructuredOutput
{
    use Promptable;

    public function instructions(): string
    {
        return <<<'INSTRUCTIONS'
        You are a sentiment analysis expert. Analyze the given text and return
        structured data about its sentiment, confidence level, key phrases,
        and a brief summary. Be precise and consistent in your analysis.
        INSTRUCTIONS;
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'sentiment' => $schema->string()->required()->description('The overall sentiment: positive, negative, or neutral'),
            'confidence' => $schema->number()->required()->description('Confidence score between 0 and 1'),
            'key_phrases' => $schema->array()->required()->description('Array of key phrases from the text'),
            'summary' => $schema->string()->required()->description('Brief summary of the sentiment analysis'),
        ];
    }
}
