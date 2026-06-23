<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleados_mnt';
    protected $fillable = ['codigo', 'nombre', 'apellidos', 'dui', 'imagen', 'activo'];

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'codigo_empleado', 'codigo');
    }
}
