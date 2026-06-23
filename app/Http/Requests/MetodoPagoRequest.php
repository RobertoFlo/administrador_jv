<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MetodoPagoRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        $id = $this->route('metodo_pago');
        return [
            'nombre' => 'required|string|max:255|unique:metodos_pago_ctl,nombre' . ($id ? ",$id" : ''),
            'descripcion' => 'nullable|string',
        ];
    }
}
