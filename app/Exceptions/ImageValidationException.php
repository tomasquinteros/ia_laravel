<?php

namespace App\Exceptions;

use Exception;

class ImageValidationException extends Exception
{
    /**
     * Render la excepción.
     */
    public function render($request)
    {
        return response()->json([
            'error' => 'La imagen está corrupta o es inválida',
        ], 422);
    }
}
