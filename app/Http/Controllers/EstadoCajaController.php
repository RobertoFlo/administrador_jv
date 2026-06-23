<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstadoCajaRequest;
use App\Models\EstadoCaja;

class EstadoCajaController extends Controller
{
    public function index()
    {
        return response()->json(EstadoCaja::all());
    }

    public function store(EstadoCajaRequest $request)
    {
        return response()->json(EstadoCaja::create($request->validated()), 201);
    }

    public function show(EstadoCaja $estadoCaja)
    {
        return response()->json($estadoCaja);
    }

    public function update(EstadoCajaRequest $request, EstadoCaja $estadoCaja)
    {
        $estadoCaja->update($request->validated());
        return response()->json($estadoCaja);
    }

    public function destroy(EstadoCaja $estadoCaja)
    {
        $estadoCaja->delete();
        return response()->json(null, 204);
    }
}
