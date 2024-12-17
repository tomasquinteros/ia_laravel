<?php

namespace App\Processors;

use App\Classes\AIChain;
use Exception;
use Illuminate\Support\Facades\Log;

class IAChainImageProcessor extends AIChain
{

    public function processImage($images_base64)
    {
        foreach ($this->getIas() as $ia) {
            try {
                if (!$ia->isAvaible()) {
                    Log::warning('La IA '.get_class($ia).' no se encuentra disponible.');
                    continue;
                }
                /*if ($reponse->status() === 500 || empty($reponse)) {
                  Log::warning('La IA '.get_class($ia).' pudo procesar las imagenes.');
                }*/
                return $ia->processImage($images_base64);
            } catch (Exception $error) {
                Log::error('Error en'.get_class($ia).':'.$error->getMessage());
            }
        }
        throw new Exception('Error al procesar las imagenes. Intente más tarde.');
    }
}
