<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $table = 'cajas_mnt';
    protected $fillable = [
        'fecha', 'saldo_inicial', 'saldo_actual', 'saldo_final', 'estado_caja_id',
    ];

    public function estadoCaja()
    {
        return $this->belongsTo(EstadoCaja::class, 'estado_caja_id');
    }

    public function movimientos()
    {
        return $this->hasMany(CajaMovimiento::class, 'caja_id');
    }
}
