<?php

namespace App\Http\Controllers;

use App\Services\MultipleImageProcessorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FincaIAController extends Controller
{
    private MultipleImageProcessorService $multipleImageProcessorService;

    public function __construct(MultipleImageProcessorService $multipleImageProcessorService)
    {
        $this->multipleImageProcessorService = $multipleImageProcessorService;
    }

    public function processMultiplesImages(Request $request): JsonResponse
    {
        $request->validate(
            [
                'images' => 'required|array|min:1|max:20',
                'images.*' => 'required|image|mimes:jpeg,png,jpg|max:1024'
            ],
            [
                'images.required' => 'Debe ingresar al menos una imagen.',
            ]
        );

        $images = $request->file('images');
        $results = $this->multipleImageProcessorService->processImages($images);

        return response()->json([
            'messages' => 'Procesamiento completado.',
            'results' => $results,
        ], 200);
    }

}
