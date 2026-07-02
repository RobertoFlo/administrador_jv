<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmpleadoRequest;
use App\Models\Empleado;

class EmpleadoController extends Controller
{
    public function index()
    {
        $search = request('search');
        $query = Empleado::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'ILIKE', "%{$search}%")
                    ->orWhere('apellidos', 'ILIKE', "%{$search}%")
                    ->orWhere('dui', 'ILIKE', "%{$search}%")
                    ->orWhere('codigo', 'ILIKE', "%{$search}%");
            });
        }

        return response()->json($query->get());
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
