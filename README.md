# Laravel AI + Langfuse Integration Examples

Nine artisan command examples showing how to integrate [Laravel AI](https://laravel.com/docs/ai) with [laravel-langfuse](https://github.com/axyr/laravel-langfuse) for LLM observability. From zero-config auto-tracing to complex multi-agent pipelines with scoring.

## Prerequisites

- PHP 8.3+
- Docker and Docker Compose
- An [Anthropic API key](https://console.anthropic.com/)

## Setup

```bash
git clone <repo-url>
cd laravel-langfuse-integration-examples/ai

# Start Langfuse locally (takes 2-3 minutes on first run)
docker compose up -d

# Install PHP dependencies
composer install

# Configure environment
cp .env.example .env
php artisan key:generate
php artisan migrate

# Add your Anthropic key to .env
# ANTHROPIC_API_KEY=sk-ant-...
```

The `.env.example` comes pre-configured with Langfuse keys that match the `docker-compose.yml` auto-provisioned project. No manual Langfuse setup needed.

**Langfuse UI:** [http://localhost:3000](http://localhost:3000) (login: `admin@example.com` / `password`)

To stop Langfuse: `docker compose down`
To reset all data: `docker compose down -v`

## Examples

| # | Command | What it demonstrates |
|---|---------|---------------------|
| 1 | `php artisan example:basic-agent` | Auto-tracing with zero Langfuse code |
| 2 | `php artisan example:agent-with-tools` | Tool calls appear as Langfuse spans |
| 3 | `php artisan example:structured-output` | Structured JSON output in generations |
| 4 | `php artisan example:streaming` | Streaming with auto-tracing |
| 5 | `php artisan example:prompt-management` | Langfuse prompt management linked to generations |
| 6 | `php artisan example:scoring` | Quality scores attached to traces |
| 7 | `php artisan example:rag-pipeline` | Nested trace hierarchy for a RAG pipeline |
| 8 | `php artisan example:multi-agent` | Multiple agents sharing a single trace |
| 9 | `php artisan example:conversation` | Multi-turn conversation with session grouping |

### Example 1: Basic Agent

The simplest integration. Enable `LANGFUSE_LARAVEL_AI_ENABLED=true` in your `.env` and every Laravel AI call is automatically traced. No Langfuse code in your application.

**Langfuse result:** Auto-created trace `laravel-ai-Summarizer` with one generation showing model, input, output, and token usage.

### Example 2: Agent with Tools

Same auto-tracing, but now the agent has tools. Each tool invocation creates a span inside the trace.

**Langfuse result:** Trace with generation + `tool-SearchWeb` and `tool-Calculator` spans.

### Example 3: Structured Output

Agent returns structured JSON via `HasStructuredOutput`. The structured response appears in the Langfuse generation output.

**Langfuse result:** Generation output shows the structured JSON with sentiment, confidence, key phrases.

### Example 4: Streaming

Streaming works identically with auto-tracing. The complete accumulated text is captured in Langfuse after the stream finishes.

**Langfuse result:** Complete generation with full text.

### Example 5: Prompt Management

Create and fetch prompts from Langfuse's prompt management. Compile them with variables and link them to generations.

**Langfuse result:** Prompt in prompt management + trace with linked generation.

### Example 6: Scoring

Attach numeric and categorical quality scores to traces for evaluation dashboards.

**Langfuse result:** Trace with generation + 3 scores (relevance, conciseness, quality).

### Example 7: RAG Pipeline

A full Retrieval-Augmented Generation pipeline with nested spans showing each step: embedding, vector search, reranking, context assembly, and answer generation.

**Langfuse result:** Nested trace tree with spans, generations, events, and scores.

### Example 8: Multi-Agent Pipeline

Two agents (Researcher and Writer) sharing a single trace. `setCurrentTrace()` ensures both agents' auto-traced generations nest under the same parent.

**Langfuse result:** Single trace with research and writing spans, each containing an auto-traced generation.

### Example 9: Conversation

Multi-turn conversation where each turn creates its own trace, all linked by a `sessionId` for Langfuse session grouping.

**Langfuse result:** 3 traces grouped by session in the Langfuse session view.

## Running Tests

```bash
php artisan test --filter=Examples
```

Tests use `Langfuse::fake()` and `Agent::fake()` to verify behavior without real API calls.

## Packages

- **[laravel/ai](https://github.com/laravel/ai)** - Laravel's first-party AI SDK
- **[axyr/laravel-langfuse](https://github.com/axyr/laravel-langfuse)** - Langfuse PHP SDK for Laravel with auto-instrumentation
