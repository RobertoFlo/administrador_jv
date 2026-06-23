<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstadoProductoRequest;
use App\Models\EstadoProducto;

class EstadoProductoController extends Controller
{
    public function index()
    {
        return response()->json(EstadoProducto::all());
    }

    public function store(EstadoProductoRequest $request)
    {
        return response()->json(EstadoProducto::create($request->validated()), 201);
    }

    public function show(EstadoProducto $estadoProducto)
    {
        return response()->json($estadoProducto);
    }

    public function update(EstadoProductoRequest $request, EstadoProducto $estadoProducto)
    {
        $estadoProducto->update($request->validated());
        return response()->json($estadoProducto);
    }

    public function destroy(EstadoProducto $estadoProducto)
    {
        $estadoProducto->delete();
        return response()->json(null, 204);
    }
}
