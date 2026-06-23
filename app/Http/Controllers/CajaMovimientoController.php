<?php

namespace App\Http\Controllers;

use App\Http\Requests\CajaMovimientoRequest;
use App\Models\Caja;
use App\Models\CajaMovimiento;

class CajaMovimientoController extends Controller
{
    public function index()
    {
        return response()->json(CajaMovimiento::with(['caja', 'estadoMovimientoCaja'])->get());
    }

    public function store(CajaMovimientoRequest $request)
    {
        $data = $request->validated();
        $movimiento = CajaMovimiento::create($data);

        $caja = Caja::findOrFail($data['caja_id']);
        $caja->increment('saldo_actual', $data['monto']);

        return response()->json($movimiento, 201);
    }

    public function show(CajaMovimiento $cajaMovimiento)
    {
        return response()->json($cajaMovimiento->load(['caja', 'estadoMovimientoCaja']));
    }

    public function destroy(CajaMovimiento $cajaMovimiento)
    {
        $caja = $cajaMovimiento->caja;
        $caja->decrement('saldo_actual', $cajaMovimiento->monto);

        $cajaMovimiento->delete();
        return response()->json(null, 204);
    }
}
