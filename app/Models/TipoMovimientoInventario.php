<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoMovimientoInventario extends Model
{
    protected $table = 'tipo_movimiento_inventario_ctl';
    protected $fillable = ['nombre', 'descripcion'];

    public function inventarioMovimientos()
    {
        return $this->hasMany(InventarioMovimiento::class, 'tipo_movimiento_inventario_id');
    }
}
