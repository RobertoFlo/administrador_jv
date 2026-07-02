<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubcategoriaRequest;
use App\Models\Subcategoria;
use Illuminate\Http\Request;

class SubcategoriaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $categoriaId = $request->input('categoria', null);
        $subcategorias = Subcategoria::query();
        if ($search) {
            $subcategorias->where('nombre', 'ILIKE', "%{$search}%");
        }
        if ($categoriaId) {
            $subcategorias->where('categoria_id', $categoriaId);
        }

        return response()->json($subcategorias->with(['categoria' => function ($query) {
            $query->withTrashed();
        }])->withTrashed()->get());
    }

    public function store(SubcategoriaRequest $request)
    {
        return response()->json(Subcategoria::create($request->validated()), 201);
    }

    public function show(Subcategoria $subcategoria)
    {
        return response()->json($subcategoria->load(['categoria' => function ($query) {
            $query->withTrashed();
        }]));
    }

    public function update(SubcategoriaRequest $request, Subcategoria $subcategoria)
    {
        $subcategoria->update($request->validated());
        return response()->json($subcategoria->load(['categoria' => function ($query) {
            $query->withTrashed();
        }]));
    }

    public function destroy(Subcategoria $subcategoria)
    {
        if ($subcategoria->trashed()) {
            $categoria = $subcategoria->categoria()->withTrashed()->first();
            if ($categoria && $categoria->trashed()) {
                return response()->json([
                    'message' => 'No se puede activar la subcategoría porque la categoría a la que pertenece está desactivada.'
                ], 422);
            }

            $subcategoria->restore();
            return response()->json(['message' => 'Subcategoría restaurada exitosamente.'], 200);
        }
        $subcategoria->delete();
        return response()->json(null, 204);
    }
}
