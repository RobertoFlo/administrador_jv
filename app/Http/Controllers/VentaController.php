<?php

namespace App\Http\Controllers;

use App\Http\Requests\VentaRequest;
use App\Models\InventarioMovimiento;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\VentaDetalle;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index()
    {
        return response()->json(Venta::with(['detalles.producto', 'metodoPago'])->get());
    }

    public function store(VentaRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $data = $request->validated();
            $venta = Venta::create([
                'numero_factura' => $data['numero_factura'],
                'codigo_empleado' => $data['codigo_empleado'],
                'metodo_pago_id' => $data['metodo_pago_id'],
                'subtotal' => $data['subtotal'],
                'total' => $data['total'],
                'comision_total' => $data['comision_total'],
            ]);

            $comisionTotal = 0;
            foreach ($data['detalles'] as $detalle) {
                $producto = Producto::findOrFail($detalle['producto_id']);

                VentaDetalle::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $detalle['producto_id'],
                    'cantidad' => $detalle['cantidad'],
                    'precio_compra' => $detalle['precio_compra'],
                    'precio_venta' => $detalle['precio_venta'],
                    'comision_unitaria' => $detalle['comision_unitaria'],
                    'subtotal' => $detalle['subtotal'],
                ]);

                $producto->decrement('stock', $detalle['cantidad']);

                InventarioMovimiento::create([
                    'producto_id' => $detalle['producto_id'],
                    'tipo_movimiento_inventario_id' => 2,
                    'cantidad' => -$detalle['cantidad'],
                    'stock_anterior' => $producto->stock + $detalle['cantidad'],
                    'stock_actual' => $producto->stock,
                    'observacion' => "Venta #{$venta->numero_factura}",
                ]);

                $comisionTotal += $detalle['comision_unitaria'] * $detalle['cantidad'];
            }

            $venta->update(['comision_total' => $comisionTotal]);

            return response()->json($venta->load('detalles.producto'), 201);
        });
    }

    public function show(Venta $venta)
    {
        return response()->json($venta->load(['detalles.producto', 'metodoPago']));
    }

    public function destroy(Venta $venta)
    {
        $venta->delete();
        return response()->json(null, 204);
    }
}
