<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompraRequest;
use App\Models\Compra;
use App\Models\CompraDetalle;
use App\Models\InventarioMovimiento;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    public function index()
    {
        $search = request('search');
        $fecha = request('fecha');
        $query = Compra::with('detalles.producto');

        if ($search) {
            $query->where('numero_compra', 'ILIKE', "%{$search}%");
        }

        if ($fecha) {
            $query->whereDate('created_at', $fecha);
        }

        return response()->json($query->orderBy('created_at', 'desc')->get());
    }

    public function store(CompraRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $data = $request->validated();
            $compra = Compra::create([
                'numero_compra' => $data['numero_compra'],
                'total' => $data['total'],
                'observacion' => $data['observacion'] ?? null,
            ]);

            foreach ($data['detalles'] as $detalle) {
                $producto = Producto::findOrFail($detalle['producto_id']);
                $stockAnterior = $producto->stock;

                CompraDetalle::create([
                    'compra_id' => $compra->id,
                    'producto_id' => $detalle['producto_id'],
                    'cantidad' => $detalle['cantidad'],
                    'costo_unitario' => $detalle['costo_unitario'],
                    'subtotal' => $detalle['subtotal'],
                ]);

                $producto->precio_compra = $detalle['costo_unitario'];
                if (isset($detalle['precio_venta']) && !is_null($detalle['precio_venta'])) {
                    $producto->precio_venta = $detalle['precio_venta'];
                }
                $producto->stock += $detalle['cantidad'];
                $producto->save();

                InventarioMovimiento::create([
                    'producto_id' => $detalle['producto_id'],
                    'tipo_movimiento_inventario_id' => 1,
                    'cantidad' => $detalle['cantidad'],
                    'stock_anterior' => $stockAnterior,
                    'stock_actual' => $producto->stock,
                    'observacion' => "Compra #{$compra->numero_compra}",
                ]);
            }

            return response()->json($compra->load('detalles.producto'), 201);
        });
    }

    public function show(Compra $compra)
    {
        return response()->json($compra->load('detalles.producto'));
    }

    public function destroy(Compra $compra)
    {
        $compra->delete();
        return response()->json(null, 204);
    }
}
