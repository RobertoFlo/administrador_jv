<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductoRequest;
use App\Models\Producto;

class ProductoController extends Controller
{
    public function index()
    {
        return response()->json(Producto::with(['categoria', 'subcategoria', 'estadoProducto'])->get());
    }

    public function store(ProductoRequest $request)
    {
        return response()->json(Producto::create($request->validated()), 201);
    }

    public function show(Producto $producto)
    {
        return response()->json($producto->load(['categoria', 'subcategoria', 'estadoProducto']));
    }

    public function update(ProductoRequest $request, Producto $producto)
    {
        $producto->update($request->validated());
        return response()->json($producto->load(['categoria', 'subcategoria', 'estadoProducto']));
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return response()->json(null, 204);
    }
}
