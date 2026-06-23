<?php

namespace App\Http\Controllers;

use App\Http\Requests\CajaRequest;
use App\Models\Caja;

class CajaController extends Controller
{
    public function index()
    {
        return response()->json(Caja::with('estadoCaja')->get());
    }

    public function store(CajaRequest $request)
    {
        $data = $request->validated();
        $data['saldo_actual'] = $data['saldo_inicial'];
        return response()->json(Caja::create($data), 201);
    }

    public function show(Caja $caja)
    {
        return response()->json($caja->load(['estadoCaja', 'movimientos']));
    }

    public function update(CajaRequest $request, Caja $caja)
    {
        $caja->update($request->validated());
        return response()->json($caja->load('estadoCaja'));
    }

    public function destroy(Caja $caja)
    {
        $caja->delete();
        return response()->json(null, 204);
    }
}
