<?php

namespace App\Processors;

use App\Interfaces\IAProcessorInterface;
use Exception;
use Gemini;

class GeminiAI implements IAProcessorInterface
{
    /**
     * Create a new class instance.
     */
    private mixed $api_key;
    private Gemini\Client $GeminiClient;

    public function __construct()
    {
        $this->api_key = env('GAMINIAI_API_KEY');
        $this->GeminiClient = Gemini::client($this->api_key);
    }

    public function processImage(string $image_base64, string $instruction): mixed
    {
        // Validamos que la IA se encuentre disponible
        if (!$this->isAvaible()) {
            throw new Exception('OpenAI no esta disponible.');
        }

        // Usamos la IA.
        try {
            // Generamos el mensaje (Lo generamos aca para que callAPI pueda ser usado en otros casos y que no sea
            // tan personalizado)
            $data = [
                $instruction,
                new Gemini\Data\Blob(
                    Gemini\Enums\MimeType::IMAGE_PNG,
                    $image_base64
                )
            ];

            $response = $this->callAPI($data);
            return $response->text();

        } catch (Exception $e) {
            throw new Exception('Error al procesar la imagen.');
        }

    }

    public function isAvaible(): bool
    {
        /* TODO crear is avaible */
        return true;
    }

    public function callAPI($message)
    {
        return $this->GeminiClient->geminiFlash()->generateContent([
            $message
        ]);
    }
}
