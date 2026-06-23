<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoMovimientoCaja extends Model
{
    //
    protected $table = 'estado_movimiento_caja_ctl';
    protected $fillable = ['nombre', 'descripcion'];

    public function cajaMovimientos()
    {
        return $this->hasMany(CajaMovimiento::class, 'estado_movimiento_caja_id');
    }
}
