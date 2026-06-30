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
        if ($search) {
            return response()->json(Subcategoria::where('nombre', 'ILIKE', "%{$search}%")->with('categoria')->get());
        }

        return response()->json(Subcategoria::with('categoria')->get());
    }

    public function store(SubcategoriaRequest $request)
    {
        return response()->json(Subcategoria::create($request->validated()), 201);
    }

    public function show(Subcategoria $subcategoria)
    {
        return response()->json($subcategoria->load('categoria'));
    }

    public function update(SubcategoriaRequest $request, Subcategoria $subcategoria)
    {
        $subcategoria->update($request->validated());
        return response()->json($subcategoria->load('categoria'));
    }

    public function destroy(Subcategoria $subcategoria)
    {
        $subcategoria->delete();
        return response()->json(null, 204);
    }
}
