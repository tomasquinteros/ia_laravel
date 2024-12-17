<?php

namespace App\Interfaces;

use Exception;

interface IAProcessorInterface
{
    /**
     *Verifica que la inteligencia artificial se encuentre disponible.
     * @return bool
     */
    public function isAvaible(): bool;

    /**
     * Procesa la imagen usando la inteligencia artificial.
     *
     * @param  string  $imagen_base64  La imagen a procesar.
     * @param  string  $instruction  Instrucciones para procesar la imagen.
     * @return mixed Puede devolver un json, text o un error.
     * @throws Exception Si la IA falla.
     */
    public function processImage(string $image_base64, string $instruction): mixed;

    public function callAPI($data);
}
