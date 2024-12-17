<?php

namespace App\Processors;

use App\Interfaces\IAProcessorInterface;
use Exception;
use Illuminate\Support\Facades\Http;
use function env;

class OpenAI implements IAProcessorInterface
{
    private mixed $API_KEY;
    private string $API_URL;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->API_KEY = env('OPENAI_API_KEY');
        $this->API_URL = env('OPENAI_API_URL');
    }

    public function processImage($image_base64, $instruction): mixed
    {
        if (!$this->isAvaible()) {
            throw new Exception('OpenAI no esta disponible.');
        }
        try {
            $data = [
                'model' => 'gpt-4o',
                'messages' => [
                    'role' => 'user',
                    'content' => [
                        ['type' => 'text', 'text' => $instruction],
                        ['type' => 'image_url', 'image_url' => 'data:image/jpeg;base64,'.$image_base64],
                    ]
                ]
            ];
            $response = $this->callAPI($data);
            return $response['choices'][0]['message']['content'];
        } catch (Exception $error) {
            throw new Exception('Error al procesar la imagen: ', $error->getMessage());
        }
    }

    public function isAvaible(): bool
    {
        // TODO: Implement isAvaible() method.
        return true;
    }

    public function callAPI($data)
    {
        return Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$this->API_KEY,
        ])->post($this->API_URL, [$data]);
    }
}
