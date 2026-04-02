<?php

declare(strict_types=1);

namespace App\Ai\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;

class SearchWeb implements Tool
{
    public function description(): string
    {
        return 'Search the web for information on a given query. Returns relevant search results.';
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'query' => $schema->string()->required()->description('The search query'),
        ];
    }

    public function handle(Request $request): string
    {
        $query = (string) $request->string('query');

        // Simulated search results for demonstration purposes
        return json_encode([
            'results' => [
                [
                    'title' => "Result 1 for: {$query}",
                    'snippet' => "This is a relevant finding about {$query}. Studies show significant developments in this area.",
                    'url' => 'https://example.com/result-1',
                ],
                [
                    'title' => "Result 2 for: {$query}",
                    'snippet' => "Recent research on {$query} indicates new trends and patterns worth exploring.",
                    'url' => 'https://example.com/result-2',
                ],
            ],
        ], JSON_THROW_ON_ERROR);
    }
}
