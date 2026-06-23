<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    //
    protected $table = 'metodos_pago_ctl';
    protected $fillable = ['nombre', 'descripcion'];

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'metodo_pago_id');
    }
}
