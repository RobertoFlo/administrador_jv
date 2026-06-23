<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | CATÁLOGOS
        |--------------------------------------------------------------------------
        */

        Schema::create('estado_producto_ctl', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('descripcion')->nullable();
            $table->timestamps();
        });

        Schema::create('tipo_movimiento_inventario_ctl', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('descripcion')->nullable();
            $table->timestamps();
        });

        Schema::create('estado_caja_ctl', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('descripcion')->nullable();
            $table->timestamps();
        });

        Schema::create('estado_movimiento_caja_ctl', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('descripcion')->nullable();
            $table->timestamps();
        });

        Schema::create('metodos_pago_ctl', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('descripcion')->nullable();
            $table->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | CATEGORÍAS
        |--------------------------------------------------------------------------
        */

        Schema::create('categorias_mnt', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        Schema::create('subcategorias_mnt', function (Blueprint $table) {
            $table->id();

            $table->foreignId('categoria_id')
                ->constrained('categorias_mnt')
                ->cascadeOnDelete();

            $table->string('nombre');
            $table->boolean('activo')->default(true);

            $table->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | PRODUCTOS
        |--------------------------------------------------------------------------
        */

        Schema::create('productos_mnt', function (Blueprint $table) {
            $table->id();

            $table->foreignId('categoria_id')
                ->constrained('categorias_mnt');

            $table->foreignId('subcategoria_id')
                ->nullable()
                ->constrained('subcategorias_mnt');

            $table->foreignId('estado_producto_id')
                ->constrained('estado_producto_ctl');

            $table->string('codigo')->unique();
            $table->string('nombre');
            $table->text('descripcion')->nullable();

            $table->decimal('precio_compra', 12, 2)->default(0);
            $table->decimal('precio_venta', 12, 2)->default(0);

            // Si la empresa te paga comisión por unidad
            $table->decimal('comision_por_unidad', 12, 2)->default(0);

            // Stock actual (consulta rápida)
            $table->integer('stock')->default(0);

            $table->integer('stock_minimo')->default(0);

            $table->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | MOVIMIENTOS INVENTARIO
        |--------------------------------------------------------------------------
        */

        Schema::create('inventario_movimientos_mnt', function (Blueprint $table) {
            $table->id();

            $table->foreignId('producto_id')
                ->constrained('productos_mnt')
                ->cascadeOnDelete();

            $table->foreignId('tipo_movimiento_inventario_id')
                ->constrained('tipo_movimiento_inventario_ctl');

            $table->integer('cantidad');

            $table->integer('stock_anterior');
            $table->integer('stock_actual');

            $table->text('observacion')->nullable();

            $table->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | CAJAS
        |--------------------------------------------------------------------------
        */

        Schema::create('cajas_mnt', function (Blueprint $table) {
            $table->id();

            $table->date('fecha');

            $table->decimal('saldo_inicial', 12, 2);

            // Consulta rápida
            $table->decimal('saldo_actual', 12, 2)->default(0);

            $table->decimal('saldo_final', 12, 2)->nullable();

            $table->foreignId('estado_caja_id')
                ->constrained('estado_caja_ctl');

            $table->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | MOVIMIENTOS DE CAJA
        |--------------------------------------------------------------------------
        */

        Schema::create('caja_movimientos_mnt', function (Blueprint $table) {
            $table->id();

            $table->foreignId('caja_id')
                ->constrained('cajas_mnt')
                ->cascadeOnDelete();

            $table->foreignId('estado_movimiento_caja_id')
                ->constrained('estado_movimiento_caja_ctl');

            $table->decimal('monto', 12, 2);

            $table->string('referencia')->nullable();

            $table->text('descripcion')->nullable();

            $table->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | VENTAS
        |--------------------------------------------------------------------------
        */

        Schema::create('ventas_mnt', function (Blueprint $table) {
            $table->id();

            $table->string('numero_factura')->unique();

            $table->string('codigo_empleado');

            $table->foreignId('metodo_pago_id')
                ->constrained('metodos_pago_ctl');

            $table->decimal('subtotal', 12, 2)->default(0);

            $table->decimal('total', 12, 2)->default(0);

            // Total de comisiones generadas en la venta
            $table->decimal('comision_total', 12, 2)->default(0);

            $table->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | DETALLE VENTAS
        |--------------------------------------------------------------------------
        */

        Schema::create('venta_detalles_mnt', function (Blueprint $table) {
            $table->id();

            $table->foreignId('venta_id')
                ->constrained('ventas_mnt')
                ->cascadeOnDelete();

            $table->foreignId('producto_id')
                ->constrained('productos_mnt');

            $table->integer('cantidad');

            $table->decimal('precio_compra', 12, 2);

            $table->decimal('precio_venta', 12, 2);

            $table->decimal('comision_unitaria', 12, 2);

            $table->decimal('subtotal', 12, 2);

            $table->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | COMPRAS
        |--------------------------------------------------------------------------
        */

        Schema::create('compras_mnt', function (Blueprint $table) {
            $table->id();

            $table->string('numero_compra')->unique();

            $table->decimal('total', 12, 2);

            $table->text('observacion')->nullable();

            $table->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | DETALLE COMPRAS
        |--------------------------------------------------------------------------
        */

        Schema::create('compra_detalles_mnt', function (Blueprint $table) {
            $table->id();

            $table->foreignId('compra_id')
                ->constrained('compras_mnt')
                ->cascadeOnDelete();

            $table->foreignId('producto_id')
                ->constrained('productos_mnt');

            $table->integer('cantidad');

            $table->decimal('costo_unitario', 12, 2);

            $table->decimal('subtotal', 12, 2);

            $table->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | EMPLEADOS (_mnt)
        |--------------------------------------------------------------------------
        */

        Schema::create('empleados_mnt', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('nombre');
            $table->string('apellidos');
            $table->string('dui')->unique();
            $table->string('imagen')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compra_detalles_mnt');
        Schema::dropIfExists('compras_mnt');

        Schema::dropIfExists('venta_detalles_mnt');
        Schema::dropIfExists('ventas_mnt');

        Schema::dropIfExists('caja_movimientos_mnt');
        Schema::dropIfExists('cajas_mnt');

        Schema::dropIfExists('inventario_movimientos_mnt');

        Schema::dropIfExists('productos_mnt');

        Schema::dropIfExists('empleados_mnt');

        Schema::dropIfExists('subcategorias_mnt');
        Schema::dropIfExists('categorias_mnt');

        Schema::dropIfExists('metodos_pago_ctl');
        Schema::dropIfExists('estado_movimiento_caja_ctl');
        Schema::dropIfExists('estado_caja_ctl');
        Schema::dropIfExists('tipo_movimiento_inventario_ctl');
        Schema::dropIfExists('estado_producto_ctl');
    }
};
