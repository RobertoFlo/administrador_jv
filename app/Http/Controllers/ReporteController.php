<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\Venta;
use App\Models\VentaDetalle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function ventas(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $ventas = Venta::with(['detalles.producto', 'metodoPago', 'empleado'])
            ->whereDate('created_at', '>=', $request->fecha_inicio)
            ->whereDate('created_at', '<=', $request->fecha_fin)
            ->orderBy('created_at')
            ->get();

        $resumen = (object) [
            'total_ventas' => $ventas->count(),
            'subtotal' => $ventas->sum('subtotal'),
            'total' => $ventas->sum('total'),
            'ganancia_real' => 0,
        ];

        $detalleProductos = VentaDetalle::join('ventas_mnt', 'venta_detalles_mnt.venta_id', '=', 'ventas_mnt.id')
            ->whereDate('ventas_mnt.created_at', '>=', $request->fecha_inicio)
            ->whereDate('ventas_mnt.created_at', '<=', $request->fecha_fin)
            ->select(
                'venta_detalles_mnt.producto_id',
                DB::raw('SUM(venta_detalles_mnt.cantidad) as total_unidades'),
                DB::raw('SUM(venta_detalles_mnt.subtotal) as total_vendido'),
                DB::raw('SUM((venta_detalles_mnt.precio_venta - venta_detalles_mnt.precio_compra - venta_detalles_mnt.comision_unitaria) * venta_detalles_mnt.cantidad) as ganancia_real')
            )
            ->groupBy('venta_detalles_mnt.producto_id')
            ->get();

        $resumen->ganancia_real = $detalleProductos->sum('ganancia_real');

        return response()->json([
            'resumen' => $resumen,
            'ventas' => $ventas,
            'productos' => $detalleProductos->load('producto'),
        ]);
    }

    public function caja(Request $request)
    {
        $request->validate(['fecha' => 'required|date']);

        $caja = Caja::with('estadoCaja')
            ->whereDate('fecha', $request->fecha)
            ->first();

        if (!$caja) {
            return response()->json(['message' => 'No hay registro de caja para esta fecha'], 404);
        }

        $movimientos = $caja->movimientos()->with('estadoMovimientoCaja')->get();
        $ingresos = $movimientos->where('monto', '>', 0)->sum('monto');
        $egresos = $movimientos->where('monto', '<', 0)->sum('monto');

        return response()->json([
            'caja' => $caja,
            'movimientos' => $movimientos,
            'resumen' => [
                'saldo_inicial' => $caja->saldo_inicial,
                'saldo_actual' => $caja->saldo_actual,
                'saldo_final' => $caja->saldo_final,
                'ingresos' => $ingresos,
                'egresos' => abs($egresos),
            ],
        ]);
    }

    public function ventasPorEmpleado(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $empleados = Venta::select(
            'codigo_empleado',
            DB::raw('COUNT(*) as total_ventas'),
            DB::raw('SUM(total) as monto_total'),
            DB::raw('SUM(comision_total) as comision_total'),
        )
            ->whereDate('created_at', '>=', $request->fecha_inicio)
            ->whereDate('created_at', '<=', $request->fecha_fin)
            ->groupBy('codigo_empleado')
            ->with('empleado')
            ->get();

        return response()->json($empleados);
    }

    public function productoMasVendido(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        $query = VentaDetalle::join('ventas_mnt', 'venta_detalles_mnt.venta_id', '=', 'ventas_mnt.id')
            ->join('productos_mnt', 'venta_detalles_mnt.producto_id', '=', 'productos_mnt.id')
            ->select(
                'venta_detalles_mnt.producto_id',
                'productos_mnt.nombre',
                'productos_mnt.codigo',
                DB::raw('SUM(venta_detalles_mnt.cantidad) as total_unidades'),
                DB::raw('SUM(venta_detalles_mnt.subtotal) as total_vendido'),
                DB::raw('SUM((venta_detalles_mnt.precio_venta - venta_detalles_mnt.precio_compra - venta_detalles_mnt.comision_unitaria) * venta_detalles_mnt.cantidad) as ganancia_real')
            );

        if ($request->fecha_inicio) {
            $query->whereDate('ventas_mnt.created_at', '>=', $request->fecha_inicio);
        }
        if ($request->fecha_fin) {
            $query->whereDate('ventas_mnt.created_at', '<=', $request->fecha_fin);
        }

        $productos = $query->groupBy(
            'venta_detalles_mnt.producto_id',
            'productos_mnt.nombre',
            'productos_mnt.codigo'
        )
            ->orderByDesc('total_unidades')
            ->get();

        return response()->json($productos);
    }
}
