<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstadoCajaRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        $id = $this->route('estado_caja');
        return [
            'nombre' => 'required|string|max:255|unique:estado_caja_ctl,nombre' . ($id ? ",$id" : ''),
            'descripcion' => 'nullable|string',
        ];
    }
}
