<?php
/**
 * @author Lukmanov Mikhail <lukmanof92@gmail.com>
 */

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenAIService
{
    protected $endpoint;
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('OPENAI_API_KEY');
        $this->endpoint = env('OPENAI_HOST');
    }

    public function ask($prompt, $model = 'davinci')
    {
        $url = str_replace('{engine}', $model, $this->endpoint);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json'
        ])->post($url, [
            'prompt' => $prompt,
            'model' => $model,
            'max_tokens' => 150
        ]);

        return $response->json();
    }
}
