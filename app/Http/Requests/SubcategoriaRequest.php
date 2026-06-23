<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubcategoriaRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        $id = $this->route('subcategoria');
        return [
            'categoria_id' => 'required|exists:categorias_mnt,id',
            'nombre' => 'required|string|max:255',
            'activo' => 'boolean',
        ];
    }
}
