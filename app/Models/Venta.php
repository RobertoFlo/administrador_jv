<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas_mnt';
    protected $fillable = [
        'numero_factura', 'codigo_empleado', 'metodo_pago_id',
        'subtotal', 'total', 'comision_total',
    ];

    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'metodo_pago_id');
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'codigo_empleado', 'codigo');
    }

    public function detalles()
    {
        return $this->hasMany(VentaDetalle::class, 'venta_id');
    }
}
