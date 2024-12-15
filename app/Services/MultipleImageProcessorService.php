<?php

namespace App\Services;

use App\Exceptions\ImageValidationException;
use App\Interfaces\IAProcessorInterface;
use Exception;

class MultipleImageProcessorService
{
    /**
     * Create a new class instance.
     */
    private IAProcessorInterface $ia_processor;

    /**
     * Inyectamos el IAChainProcessor o cualquier procesador que implemente la interfaz. La idea es poder usar el
     * servicio dentro de este servicio.
     * @param  IAProcessorInterface  $ia_processor
     */
    public function __construct(IAProcessorInterface $ia_processor)
    {
        $this->ia_processor = $ia_processor;
    }


    /**
     * @param  array  $images
     * @return array
     */
    public function processImages(array $images): array
    {
        $results = [];

        foreach ($images as $image) {
            try {
                // Validamos y convertimos la imagen en base64.
                $image_base64 = $this->validateAndConvertImageBase64($image);
                // Procesamos la imagen mediante la IA.
                $process = $this->ia_processor->processImage($image_base64);
                // Guardamos la imagen en el servidor.
                $this->saveImageLocal($image);

                // Guardamos el resultado del procesamiento dentro del array.
                $results[] = [
                    'image_name' => $image->getClientOrginalName(),
                    'process' => $process,
                    'status' => 200,
                ];
            } catch (ImageValidationException $error) {
                $results[] = [
                    'image_name' => $image->getClientOriginalName(),
                    'process' => 'Imagen corrupta o no valida.',
                    'status' => 500,
                ];
            } catch (Exception $error) {
                $results[] = [
                    'image_name' => $image->getClientOriginalName(),
                    'process' => 'No se pudo procesar con ninguna IA.',
                    'status' => 500,
                ];

            }
        }

        return $results;
    }

    /**
     *Valida y convierte la imagen en un base64.
     * @param $image
     * @return mixed string || ImageValidationException
     */
    private function validateAndConvertImageBase64($image): string
    {
        try {
            $path = $image->getPathname();
            $content = file_get_contents($path);
            return base64_encode($content);
        } catch (Exception $e) {
            throw new ImageValidationException('La imagen está corrupta o no es válida.');
        }
    }

    /**
     *Guardar imagen en local
     * @param $image
     * @return void
     */
    private function saveImageLocal($image): void
    {
        $imagePath = storage_path('app/images');
        $imageName = $image->hashName();
        $image->move($imagePath, $imageName);
    }
}
