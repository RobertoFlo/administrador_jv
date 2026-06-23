<?php

namespace App\Http\Controllers;

use App\Models\VentaDetalle;

class VentaDetalleController extends Controller
{
    public function index()
    {
        return response()->json(VentaDetalle::with(['venta', 'producto'])->get());
    }

    public function show(VentaDetalle $ventaDetalle)
    {
        return response()->json($ventaDetalle->load(['venta', 'producto']));
    }

    public function destroy(VentaDetalle $ventaDetalle)
    {
        $ventaDetalle->delete();
        return response()->json(null, 204);
    }
}
