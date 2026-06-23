<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CajaMovimiento extends Model
{
    protected $table = 'caja_movimientos_mnt';
    protected $fillable = [
        'caja_id', 'estado_movimiento_caja_id', 'monto', 'referencia', 'descripcion',
    ];

    public function caja()
    {
        return $this->belongsTo(Caja::class, 'caja_id');
    }

    public function estadoMovimientoCaja()
    {
        return $this->belongsTo(EstadoMovimientoCaja::class, 'estado_movimiento_caja_id');
    }
}
