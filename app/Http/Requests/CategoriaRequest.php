<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriaRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        $id = $this->route('categoria');
        return [
            'nombre' => 'required|string|max:255' . ($id ? ",$id" : ''),
            'activo' => 'boolean',
        ];
    }
}
