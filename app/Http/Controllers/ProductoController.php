<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductoRequest;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $productos = Producto::with(['categoria', 'subcategoria', 'estadoProducto'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nombre', 'ILIKE', "%{$search}%")
                      ->orWhere('codigo', 'ILIKE', "%{$search}%");
                });
            })
            ->get();

        return response()->json($productos);
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
