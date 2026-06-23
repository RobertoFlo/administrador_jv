<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoCaja extends Model
{
    //
    protected $table = 'estado_caja_ctl';
    protected $fillable = ['nombre', 'descripcion'];

    public function cajas()
    {
        return $this->hasMany(Caja::class, 'estado_caja_id');
    }
}
