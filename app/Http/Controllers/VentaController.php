<?php

namespace App\Http\Controllers;

use App\Http\Requests\VentaRequest;
use App\Models\Caja;
use App\Models\CajaMovimiento;
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
                'referencia_pago' => $data['referencia_pago'] ?? null, // Guardamos la referencia
                'metodo_pago_id' => $data['metodo_pago_id'],
                'subtotal' => $data['subtotal'],
                'total' => $data['total'],
            ]);

            foreach ($data['detalles'] as $detalle) {
                $producto = Producto::findOrFail($detalle['producto_id']);

                VentaDetalle::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $detalle['producto_id'],
                    'cantidad' => $detalle['cantidad'],
                    'precio_compra' => $detalle['precio_compra'],
                    'precio_venta' => $detalle['precio_venta'],
                    'subtotal' => $detalle['subtotal'],
                ]);

                if ($producto->producto_fisico !== false) {
                    $producto->decrement('stock', $detalle['cantidad']);

                    InventarioMovimiento::create([
                        'producto_id' => $detalle['producto_id'],
                        'tipo_movimiento_inventario_id' => 2,
                        'cantidad' => -$detalle['cantidad'],
                        'stock_anterior' => $producto->stock + $detalle['cantidad'],
                        'stock_actual' => $producto->stock,
                        'observacion' => "Venta #{$venta->numero_factura}",
                    ]);
                }
            }

            // --- LÓGICA DE CAJA ---
            // ID 1 = EFECTIVO según tu seeder (seeder_catalogos.php)
            if ($data['metodo_pago_id'] == 1) {
                // Buscamos la caja que esté abierta hoy
                $cajaAbierta = Caja::where('estado_caja_id', 1)->firstOrFail(); // 1 = ABIERTA

                CajaMovimiento::create([
                    'caja_id' => $cajaAbierta->id,
                    'estado_movimiento_caja_id' => 2, // 2 = INGRESO
                    'monto' => $venta->total,
                    'referencia' => "Venta #{$venta->numero_factura}",
                    'descripcion' => 'Ingreso por venta en efectivo',
                ]);
                // Actualizamos el saldo rápido de la caja
                $cajaAbierta->increment('saldo_actual', $venta->total);
            }

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
