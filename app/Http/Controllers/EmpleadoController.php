<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmpleadoRequest;
use App\Models\Empleado;

class EmpleadoController extends Controller
{
    public function index()
    {
        return response()->json(Empleado::all());
    }

    public function store(EmpleadoRequest $request)
    {
        return response()->json(Empleado::create($request->validated()), 201);
    }

    public function show(Empleado $empleado)
    {
        return response()->json($empleado);
    }

    public function update(EmpleadoRequest $request, Empleado $empleado)
    {
        $empleado->update($request->validated());
        return response()->json($empleado);
    }

    public function destroy(Empleado $empleado)
    {
        $empleado->delete();
        return response()->json(null, 204);
    }
}
