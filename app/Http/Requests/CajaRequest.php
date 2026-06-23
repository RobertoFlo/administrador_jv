<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CajaRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        return [
            'fecha' => 'required|date',
            'saldo_inicial' => 'required|numeric|min:0',
            'saldo_final' => 'nullable|numeric|min:0',
            'estado_caja_id' => 'required|exists:estado_caja_ctl,id',
        ];
    }
}
