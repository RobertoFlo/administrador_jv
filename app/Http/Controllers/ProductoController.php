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

    private function procesarDatosProducto(array $data): array
    {
        $esFisico = !isset($data['producto_fisico']) || filter_var($data['producto_fisico'], FILTER_VALIDATE_BOOLEAN);

        if (!$esFisico) {
            $data['producto_fisico'] = false;
            $data['precio_compra'] = 0;
            $data['stock'] = 0;
            $data['stock_minimo'] = 0;
        } else {
            $data['producto_fisico'] = true;
            $data['precio_compra'] = $data['precio_compra'] ?? 0;
            $data['stock'] = $data['stock'] ?? 0;
            $data['stock_minimo'] = $data['stock_minimo'] ?? 0;
        }

        return $data;
    }

    public function store(ProductoRequest $request)
    {
        $data = $this->procesarDatosProducto($request->validated());
        return response()->json(Producto::create($data), 201);
    }

    public function show(Producto $producto)
    {
        return response()->json($producto->load(['categoria', 'subcategoria', 'estadoProducto']));
    }

    public function update(ProductoRequest $request, Producto $producto)
    {
        $data = $this->procesarDatosProducto($request->validated());
        $producto->update($data);
        return response()->json($producto->load(['categoria', 'subcategoria', 'estadoProducto']));
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return response()->json(null, 204);
    }
}
