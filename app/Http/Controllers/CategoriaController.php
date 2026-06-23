<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriaRequest;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function index()
    {
        return response()->json(Categoria::with('subcategorias')->get());
    }

    public function store(CategoriaRequest $request)
    {
        return response()->json(Categoria::create($request->validated()), 201);
    }

    public function show(Categoria $categoria)
    {
        return response()->json($categoria->load('subcategorias'));
    }

    public function update(CategoriaRequest $request, Categoria $categoria)
    {
        $categoria->update($request->validated());
        return response()->json($categoria->load('subcategorias'));
    }

    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        return response()->json(null, 204);
    }
}
