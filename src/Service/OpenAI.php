<?php
namespace App\Service;

use GuzzleHttp\Client;

class OpenAI
{
    private Client $client;
    private string $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->client = new Client([
            'base_uri' => 'https://api.openai.com/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function chat(array $messages): ?string
    {
        $body = [
            'model' => 'gpt-4o-mini',
            'messages' => $messages,
        ];

        try {
            $response = $this->client->post('chat/completions', [
                'json' => $body
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            return $data['choices'][0]['message']['content'] ?? null;

        } catch (\Exception $e) {
            throw new \RuntimeException('Error communicating with OpenAI API: ' . $e->getMessage());
        }
    }
}
