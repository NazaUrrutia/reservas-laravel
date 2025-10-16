<?php

namespace App\Http\Requests;

use App\Models\Reservation;
use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'created_by' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
            'lat' => ['required', 'numeric', 'min:-90', 'max:90'],
            'lng' => ['required', 'numeric', 'min:-180', 'max:180'],
            'state' => ['sometimes', 'in:' . implode(',', [
                Reservation::STATE_RESERVED,
                Reservation::STATE_SCHEDULED,
                Reservation::STATE_INSTALLED,
                Reservation::STATE_UNINSTALLED,
                Reservation::STATE_CANCELED,
            ])],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'created_by.required' => 'El creador es obligatorio.',
            'address.required' => 'La dirección es obligatoria.',
            'lat.required' => 'La latitud es obligatoria.',
            'lat.min' => 'La latitud debe estar entre -90 y 90.',
            'lat.max' => 'La latitud debe estar entre -90 y 90.',
            'lng.required' => 'La longitud es obligatoria.',
            'lng.min' => 'La longitud debe estar entre -180 y 180.',
            'lng.max' => 'La longitud debe estar entre -180 y 180.',
        ];
    }
}