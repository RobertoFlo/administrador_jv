<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriaRequest;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index(Request $request)
    {

        $categorias = Categoria::with('subcategorias')
            ->when($request->search, function ($query) use ($request) {
                $query->where('nombre', 'ILIKE', "%{$request->search}%");
            })
            ->orderBy('id', 'desc')
            ->withTrashed()
            ->get();
        return response()->json($categorias);
    }

    public function store(CategoriaRequest $request)
    {
        return response()->json(Categoria::create($request->validated()), 201);
    }

    public function show(Categoria $categoria)
    {
        return response()->json($categoria->load(['subcategorias' => function ($query) {
            $query->withTrashed();
        }]));
    }

    public function update(CategoriaRequest $request, Categoria $categoria)
    {
        $categoria->update($request->validated());
        return response()->json($categoria->load('subcategorias'));
    }

    public function destroy(Categoria $categoria)
    {

        if ($categoria->trashed()) {
            $categoria->restore();
            $categoria->subcategorias()->onlyTrashed()->restore();
            return response()->json(['message' => 'Categoría restaurada exitosamente.'], 200);
        }
        $categoria->subcategorias()->delete();
        $categoria->delete();
        return response()->json(['message' => 'Categoría movida a la papelera.'], 200);
    }

    public function subcategorias(Categoria $categoria)
    {
        return response()->json($categoria->subcategorias()->withTrashed()->get());
    }
}
