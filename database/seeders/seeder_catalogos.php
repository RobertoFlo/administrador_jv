<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class seeder_catalogos extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Estado Producto
        |--------------------------------------------------------------------------
        */ 
        DB::table('estado_producto_ctl')->insert([
            [
                'nombre' => 'ACTIVO',
                'descripcion' => 'Producto disponible para la venta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'INACTIVO',
                'descripcion' => 'Producto deshabilitado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'AGOTADO',
                'descripcion' => 'Producto sin existencias',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'DESCONTINUADO',
                'descripcion' => 'Producto fuera del catálogo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Tipo Movimiento Inventario
        |--------------------------------------------------------------------------
        */
        DB::table('tipo_movimiento_inventario_ctl')->insert([
            [
                'nombre' => 'ENTRADA',
                'descripcion' => 'Ingreso de productos al inventario',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'SALIDA',
                'descripcion' => 'Salida por venta o retiro',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'AJUSTE',
                'descripcion' => 'Corrección de inventario',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Estado Caja
        |--------------------------------------------------------------------------
        */
        DB::table('estado_caja_ctl')->insert([
            [
                'nombre' => 'ABIERTA',
                'descripcion' => 'Caja abierta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'CERRADA',
                'descripcion' => 'Caja cerrada',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Estado Movimiento Caja
        |--------------------------------------------------------------------------
        */
        DB::table('estado_movimiento_caja_ctl')->insert([
            [
                'nombre' => 'APERTURA',
                'descripcion' => 'Apertura de caja',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'INGRESO',
                'descripcion' => 'Ingreso de dinero',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'EGRESO',
                'descripcion' => 'Salida de dinero',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'AJUSTE',
                'descripcion' => 'Ajuste de caja',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'CIERRE',
                'descripcion' => 'Cierre de caja',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Métodos de Pago
        |--------------------------------------------------------------------------
        */
        DB::table('metodos_pago_ctl')->insert([
            [
                'nombre' => 'EFECTIVO',
                'descripcion' => 'Pago en efectivo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'TARJETA',
                'descripcion' => 'Pago con tarjeta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'TRANSFERENCIA',
                'descripcion' => 'Transferencia bancaria',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'QR',
                'descripcion' => 'Pago mediante código QR',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'CRÉDITO',
                'descripcion' => 'Venta al crédito',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
