<?php

declare(strict_types=1);

namespace App\Ai\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;

class Calculator implements Tool
{
    public function description(): string
    {
        return 'Evaluate a mathematical expression and return the result.';
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'expression' => $schema->string()->required()->description('The mathematical expression to evaluate, e.g. "2 + 2" or "sqrt(16)"'),
        ];
    }

    public function handle(Request $request): string
    {
        $expression = (string) $request->string('expression');

        // Simple safe evaluation for basic math
        $sanitized = preg_replace('/[^0-9+\-*\/().%\s]/', '', $expression);

        if ($sanitized === '' || $sanitized === null) {
            return (string) json_encode(['error' => 'Invalid expression', 'expression' => $expression]);
        }

        try {
            $result = eval("return (float)({$sanitized});");

            return (string) json_encode([
                'expression' => $expression,
                'result' => $result,
            ]);
        } catch (\Throwable) {
            return (string) json_encode([
                'expression' => $expression,
                'error' => 'Could not evaluate expression',
            ]);
        }
    }
}
