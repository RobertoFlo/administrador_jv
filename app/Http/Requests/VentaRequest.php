<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VentaRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        return [
            'numero_factura' => 'required|string|max:255|unique:ventas_mnt,numero_factura',
            'codigo_empleado' => 'required|string|max:50',
            'metodo_pago_id' => 'required|exists:metodos_pago_ctl,id',
            'subtotal' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'detalles' => 'required|array|min:1',
            'detalles.*.producto_id' => 'required|exists:productos_mnt,id',
            'detalles.*.cantidad' => 'required|integer|min:1',
            'detalles.*.precio_compra' => 'required|numeric|min:0',
            'detalles.*.precio_venta' => 'required|numeric|min:0',
            'detalles.*.subtotal' => 'required|numeric|min:0',
        ];
    }
}
