<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        $id = $this->route('producto');
        $idVal = is_object($id) ? $id->id : $id;
        
        return [
            'categoria_id' => 'required|exists:categorias_mnt,id',
            'subcategoria_id' => 'nullable|exists:subcategorias_mnt,id',
            'estado_producto_id' => 'required|exists:estado_producto_ctl,id',
            'producto_fisico' => 'nullable|boolean',
            'codigo' => 'required|string|max:255|unique:productos_mnt,codigo' . ($idVal ? ",$idVal" : ''),
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio_compra' => 'nullable|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'stock_minimo' => 'nullable|integer|min:0',
        ];
    }
}
