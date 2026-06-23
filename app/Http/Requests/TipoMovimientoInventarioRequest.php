<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoMovimientoInventarioRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        $id = $this->route('tipo_movimiento_inventario');
        return [
            'nombre' => 'required|string|max:255|unique:tipo_movimiento_inventario_ctl,nombre' . ($id ? ",$id" : ''),
            'descripcion' => 'nullable|string',
        ];
    }
}
