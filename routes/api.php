<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\CajaMovimientoController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\CompraDetalleController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\EstadoCajaController;
use App\Http\Controllers\EstadoMovimientoCajaController;
use App\Http\Controllers\EstadoProductoController;
use App\Http\Controllers\InventarioMovimientoController;
use App\Http\Controllers\MetodoPagoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\SubcategoriaController;
use App\Http\Controllers\TipoMovimientoInventarioController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\VentaDetalleController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('estados-producto', EstadoProductoController::class);
    Route::apiResource('tipos-movimiento-inventario', TipoMovimientoInventarioController::class);
    Route::apiResource('estados-caja', EstadoCajaController::class);
    Route::apiResource('estados-movimiento-caja', EstadoMovimientoCajaController::class);
    Route::apiResource('metodos-pago', MetodoPagoController::class);
    Route::apiResource('categorias', CategoriaController::class)->withTrashed(['show', 'update', 'destroy']);
    Route::get('categorias/{categoria}/subcategoria', [CategoriaController::class, 'subcategorias'])->withTrashed();
    Route::apiResource('subcategorias', SubcategoriaController::class)->withTrashed(['show', 'update', 'destroy']);
    Route::apiResource('empleados', EmpleadoController::class);
    Route::apiResource('productos', ProductoController::class);
    Route::apiResource('inventario-movimientos', InventarioMovimientoController::class)->except(['update']);
    Route::apiResource('cajas', CajaController::class);
    Route::apiResource('caja-movimientos', CajaMovimientoController::class)->except(['update']);
    Route::apiResource('ventas', VentaController::class)->except(['update']);
    Route::apiResource('venta-detalles', VentaDetalleController::class)->only(['index', 'show', 'destroy']);
    Route::apiResource('compras', CompraController::class)->except(['update']);
    Route::apiResource('compra-detalles', CompraDetalleController::class)->only(['index', 'show', 'destroy']);

    Route::prefix('reportes')->group(function () {
        Route::get('dashboard-stats', [ReporteController::class, 'dashboardStats']);
        Route::get('ventas', [ReporteController::class, 'ventas']);
        Route::get('caja', [ReporteController::class, 'caja']);
        Route::get('ventas-por-empleado', [ReporteController::class, 'ventasPorEmpleado']);
        Route::get('producto-mas-vendido', [ReporteController::class, 'productoMasVendido']);
    });
});
