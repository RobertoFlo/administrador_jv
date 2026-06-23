<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstadoMovimientoCajaRequest;
use App\Models\EstadoMovimientoCaja;

class EstadoMovimientoCajaController extends Controller
{
    public function index()
    {
        return response()->json(EstadoMovimientoCaja::all());
    }

    public function store(EstadoMovimientoCajaRequest $request)
    {
        return response()->json(EstadoMovimientoCaja::create($request->validated()), 201);
    }

    public function show(EstadoMovimientoCaja $estadoMovimientoCaja)
    {
        return response()->json($estadoMovimientoCaja);
    }

    public function update(EstadoMovimientoCajaRequest $request, EstadoMovimientoCaja $estadoMovimientoCaja)
    {
        $estadoMovimientoCaja->update($request->validated());
        return response()->json($estadoMovimientoCaja);
    }

    public function destroy(EstadoMovimientoCaja $estadoMovimientoCaja)
    {
        $estadoMovimientoCaja->delete();
        return response()->json(null, 204);
    }
}
