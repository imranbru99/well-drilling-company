<?php

namespace App\Services;

use App\Models\ChatLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AiService
{
    /** @var array<int, array{q: string, a: string}> */
    protected array $faq = [
        [
            'q' => 'how long drill timeline schedule depth',
            'a' => 'Most residential water wells in Northeast Oklahoma take 1–3 days to drill and case depending on depth and geology, plus a follow-up day for pump installation. Stonebore typically books site surveys within 2–3 business days across Tulsa, Broken Arrow, Owasso, and Claremore.',
        ],
        [
            'q' => 'cost price estimate quote well drilling',
            'a' => 'Residential water wells often range from about $8,000–$25,000+ depending on depth, casing, and pump package. Agricultural and commercial wells vary with yield targets. Request a free site survey for an exact written quote.',
        ],
        [
            'q' => 'pump submersible pressure tank repair',
            'a' => 'We install and service submersible pumps, pressure tanks, and control panels. Short cycling, low pressure, or a tripped breaker usually means a failing pump, check valve, or tank pre-charge issue — we diagnose before recommending a pull-and-replace.',
        ],
        [
            'q' => 'hydrofracturing yield low water dry',
            'a' => 'Hydrofracturing can improve yield in suitable rock when a well underperforms after development. Stonebore evaluates geology and risk first, then retests static and pumping levels so you see measurable before-and-after results.',
        ],
        [
            'q' => 'water test bacteria mineral quality treatment',
            'a' => 'We sample for bacteria and common minerals, explain results plainly, and recommend filtration or disinfection when needed. New wells should be tested after development and disinfection; older private wells benefit from periodic retesting.',
        ],
        [
            'q' => 'agricultural livestock ranch farm cattle',
            'a' => 'Farm and ranch wells are sized for livestock troughs, washdown, and limited irrigation feed. We document yield and set pumps for real peak demand so herds are not left short during dry Oklahoma summers.',
        ],
        [
            'q' => 'schedule appointment survey contact',
            'a' => 'Call or text (918) 555-0147, use the contact form, or WhatsApp us. Site surveys for Tulsa, Broken Arrow, Owasso, Claremore, and nearby Northeast Oklahoma towns are usually available within 2–3 business days.',
        ],
        [
            'q' => 'commercial community industrial campus',
            'a' => 'For commercial and small community wells we coordinate site logistics, deliver as-built logs and pump curves, and can specify backup pumps or flow monitoring for critical facilities.',
        ],
    ];

    public function chat(string $message, ?string $sessionId = null): array
    {
        $reply = null;
        $source = 'demo';

        if ($key = config('services.openai.key')) {
            try {
                $reply = $this->callOpenAi($message, $key);
                $source = 'openai';
            } catch (\Throwable) {
                $reply = null;
            }
        }

        if (! $reply && ($gemini = config('services.gemini.key'))) {
            try {
                $reply = $this->callGemini($message, $gemini);
                $source = 'gemini';
            } catch (\Throwable) {
                $reply = null;
            }
        }

        if (! $reply) {
            $reply = $this->demoReply($message);
            $source = 'demo';
        }

        ChatLog::query()->create([
            'session_id' => $sessionId,
            'message' => $message,
            'reply' => $reply,
            'source' => $source,
        ]);

        return ['reply' => $reply, 'source' => $source];
    }

    public function generate(string $type, string $prompt): string
    {
        $message = match ($type) {
            'blog' => "Write a concise SEO blog post outline and intro for a water well drilling company about: {$prompt}",
            'description' => "Write a compelling product/service description for water well drilling and pumps: {$prompt}",
            'automation' => "Suggest 5 practical AI automations for a well drilling SME ERP related to: {$prompt}",
            'troubleshoot' => "Troubleshoot this well drilling operations issue with clear steps: {$prompt}",
            default => $prompt,
        };

        $result = $this->chat($message);

        return $result['reply'];
    }

    protected function demoReply(string $message): string
    {
        $hay = Str::lower($message);
        $best = null;
        $bestScore = 0;

        foreach ($this->faq as $item) {
            $score = 0;
            foreach (explode(' ', $item['q']) as $word) {
                if ($word !== '' && str_contains($hay, $word)) {
                    $score++;
                }
            }
            if ($score > $bestScore) {
                $bestScore = $score;
                $best = $item['a'];
            }
        }

        if ($best && $bestScore > 0) {
            return $best;
        }

        return 'Thanks for reaching Stonebore Well Co. We drill residential, agricultural, and commercial water wells across Tulsa and Northeast Oklahoma — plus pumps, hydrofracturing, and water testing. Ask about pricing, depth, pumps, or scheduling—or call (918) 555-0147 for a free site survey.';
    }

    protected function callOpenAi(string $message, string $key): string
    {
        $response = Http::withToken($key)
            ->timeout(30)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => config('services.openai.model', 'gpt-4o-mini'),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are the Stonebore Well Co. assistant for a Tulsa / Northeast Oklahoma water well drilling company. Be concise, practical, and focused on residential/agricultural/commercial wells, pumps, hydrofracturing, and water testing. Never invent illegal claims.',
                    ],
                    ['role' => 'user', 'content' => $message],
                ],
                'temperature' => 0.4,
            ]);

        $response->throw();

        return (string) data_get($response->json(), 'choices.0.message.content', 'Unable to generate a response.');
    }

    protected function callGemini(string $message, string $key): string
    {
        $model = config('services.gemini.model', 'gemini-1.5-flash');
        $response = Http::timeout(30)
            ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$key}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => "You are Stonebore Well Co. assistant (Tulsa water well drilling). Answer briefly:\n{$message}"],
                        ],
                    ],
                ],
            ]);

        $response->throw();

        return (string) data_get($response->json(), 'candidates.0.content.parts.0.text', 'Unable to generate a response.');
    }
}
