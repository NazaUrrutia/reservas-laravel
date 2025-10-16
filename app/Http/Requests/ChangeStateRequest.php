<?php

namespace App\Http\Requests;

use App\Models\Reservation;
use Illuminate\Foundation\Http\FormRequest;

class ChangeStateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'state' => ['required', 'in:' . implode(',', [
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
            'state.required' => 'El estado es obligatorio.',
            'state.in' => 'El estado no es válido.',
        ];
    }
}