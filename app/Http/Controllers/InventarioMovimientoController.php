<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventarioMovimientoRequest;
use App\Models\InventarioMovimiento;
use App\Models\Producto;

class InventarioMovimientoController extends Controller
{
    public function index()
    {
        return response()->json(InventarioMovimiento::with(['producto', 'tipoMovimientoInventario'])->get());
    }

    public function store(InventarioMovimientoRequest $request)
    {
        $data = $request->validated();

        $producto = Producto::findOrFail($data['producto_id']);
        $data['stock_anterior'] = $producto->stock;

        if ($data['cantidad'] > 0) {
            $data['stock_actual'] = $producto->stock + $data['cantidad'];
        } else {
            $data['stock_actual'] = $producto->stock - abs($data['cantidad']);
        }

        $producto->update(['stock' => $data['stock_actual']]);

        return response()->json(InventarioMovimiento::create($data), 201);
    }

    public function show(InventarioMovimiento $inventarioMovimiento)
    {
        return response()->json($inventarioMovimiento->load(['producto', 'tipoMovimientoInventario']));
    }

    public function destroy(InventarioMovimiento $inventarioMovimiento)
    {
        $producto = $inventarioMovimiento->producto;
        $diferencia = $inventarioMovimiento->stock_actual - $inventarioMovimiento->stock_anterior;
        $producto->decrement('stock', $diferencia);

        $inventarioMovimiento->delete();
        return response()->json(null, 204);
    }
}
