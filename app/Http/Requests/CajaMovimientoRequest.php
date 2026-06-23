<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CajaMovimientoRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        return [
            'caja_id' => 'required|exists:cajas_mnt,id',
            'estado_movimiento_caja_id' => 'required|exists:estado_movimiento_caja_ctl,id',
            'monto' => 'required|numeric',
            'referencia' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
        ];
    }
}
