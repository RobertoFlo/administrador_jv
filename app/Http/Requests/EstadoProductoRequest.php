<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstadoProductoRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        $id = $this->route('estado_producto');
        return [
            'nombre' => 'required|string|max:255|unique:estado_producto_ctl,nombre' . ($id ? ",$id" : ''),
            'descripcion' => 'nullable|string',
        ];
    }
}
