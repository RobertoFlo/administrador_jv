<?php

namespace App\Http\Controllers;

use App\Models\CompraDetalle;

class CompraDetalleController extends Controller
{
    public function index()
    {
        return response()->json(CompraDetalle::with(['compra', 'producto'])->get());
    }

    public function show(CompraDetalle $compraDetalle)
    {
        return response()->json($compraDetalle->load(['compra', 'producto']));
    }

    public function destroy(CompraDetalle $compraDetalle)
    {
        $compraDetalle->delete();
        return response()->json(null, 204);
    }
}
