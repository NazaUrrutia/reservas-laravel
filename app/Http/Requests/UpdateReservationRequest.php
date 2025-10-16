<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'created_by' => ['sometimes', 'string', 'max:255'],
            'address' => ['sometimes', 'string', 'max:500'],
            'lat' => ['sometimes', 'numeric', 'min:-90', 'max:90'],
            'lng' => ['sometimes', 'numeric', 'min:-180', 'max:180'],
        ];
    }

    public function messages(): array
    {
        return [
            'lat.min' => 'La latitud debe estar entre -90 y 90.',
            'lat.max' => 'La latitud debe estar entre -90 y 90.',
            'lng.min' => 'La longitud debe estar entre -180 y 180.',
            'lng.max' => 'La longitud debe estar entre -180 y 180.',
        ];
    }
}