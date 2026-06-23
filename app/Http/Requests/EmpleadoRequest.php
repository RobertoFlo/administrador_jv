<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpleadoRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        $id = $this->route('empleado');
        return [
            'codigo' => 'required|string|max:50|unique:empleados_mnt,codigo' . ($id ? ",$id" : ''),
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'dui' => 'required|string|max:10|unique:empleados_mnt,dui' . ($id ? ",$id" : ''),
            'imagen' => 'nullable|string|max:255',
            'activo' => 'boolean',
        ];
    }
}
