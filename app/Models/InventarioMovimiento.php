<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventarioMovimiento extends Model
{
    protected $table = 'inventario_movimientos_mnt';
    protected $fillable = [
        'producto_id', 'tipo_movimiento_inventario_id',
        'cantidad', 'stock_anterior', 'stock_actual', 'observacion',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function tipoMovimientoInventario()
    {
        return $this->belongsTo(TipoMovimientoInventario::class, 'tipo_movimiento_inventario_id');
    }
}
