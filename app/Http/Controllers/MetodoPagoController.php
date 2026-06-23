<?php

namespace App\Http\Controllers;

use App\Http\Requests\MetodoPagoRequest;
use App\Models\MetodoPago;

class MetodoPagoController extends Controller
{
    public function index()
    {
        return response()->json(MetodoPago::all());
    }

    public function store(MetodoPagoRequest $request)
    {
        return response()->json(MetodoPago::create($request->validated()), 201);
    }

    public function show(MetodoPago $metodoPago)
    {
        return response()->json($metodoPago);
    }

    public function update(MetodoPagoRequest $request, MetodoPago $metodoPago)
    {
        $metodoPago->update($request->validated());
        return response()->json($metodoPago);
    }

    public function destroy(MetodoPago $metodoPago)
    {
        $metodoPago->delete();
        return response()->json(null, 204);
    }
}
