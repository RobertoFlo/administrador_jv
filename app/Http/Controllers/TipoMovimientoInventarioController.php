<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoMovimientoInventarioRequest;
use App\Models\TipoMovimientoInventario;

class TipoMovimientoInventarioController extends Controller
{
    public function index()
    {
        return response()->json(TipoMovimientoInventario::all());
    }

    public function store(TipoMovimientoInventarioRequest $request)
    {
        return response()->json(TipoMovimientoInventario::create($request->validated()), 201);
    }

    public function show(TipoMovimientoInventario $tipoMovimientoInventario)
    {
        return response()->json($tipoMovimientoInventario);
    }

    public function update(TipoMovimientoInventarioRequest $request, TipoMovimientoInventario $tipoMovimientoInventario)
    {
        $tipoMovimientoInventario->update($request->validated());
        return response()->json($tipoMovimientoInventario);
    }

    public function destroy(TipoMovimientoInventario $tipoMovimientoInventario)
    {
        $tipoMovimientoInventario->delete();
        return response()->json(null, 204);
    }
}
