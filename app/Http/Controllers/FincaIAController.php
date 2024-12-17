<?php

namespace App\Http\Controllers;

use App\Http\Requests\FincaIAProcessImageRequest;
use App\Services\MultipleImageProcessorService;
use Illuminate\Http\JsonResponse;

class FincaIAController extends Controller
{
    private MultipleImageProcessorService $multipleImageProcessorService;

    // Instancion el servicio de procesamiento de multiples imagenes.
    public function __construct(MultipleImageProcessorService $multipleImageProcessorService)
    {
        $this->multipleImageProcessorService = $multipleImageProcessorService;
    }

    public function processMultiplesImages(FincaIAProcessImageRequest $request): JsonResponse
    {
        // Al usar Request personalizado, ya a la hora de recibir el dato lo valida. Si da error devuelve
        // directamente el error. Si está validado los requerimentos, pasa a hacer todo el proceso dentro del metodo.


        $images = $request->file('images');
        $results = $this->multipleImageProcessorService->processImages($images,
            $instruction = 'Generar imagen de finca');

        return response()->json([
            'messages' => 'Procesamiento completado.',
            'results' => $results,
        ], 200);
    }

}
