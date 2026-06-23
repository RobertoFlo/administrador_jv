<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventarioMovimientoRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        return [
            'producto_id' => 'required|exists:productos_mnt,id',
            'tipo_movimiento_inventario_id' => 'required|exists:tipo_movimiento_inventario_ctl,id',
            'cantidad' => 'required|integer',
            'observacion' => 'nullable|string',
        ];
    }
}
