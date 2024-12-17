<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class FincaIAProcessImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'images' => 'required|array|min:1|max:20',
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:1024'
        ];
    }

    public function messages(): array
    {
        return [
            'images.required' => 'Debe seleccionar al menos una imagen.',
            'images.max' => 'Puede mandar hasta 20 imagenes.',
            'images.*.mimes' => 'Solo se aceptan imagenes.',
        ];
    }
}
