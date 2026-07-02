<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos_mnt';
    protected $fillable = [
        'categoria_id', 'subcategoria_id', 'estado_producto_id',
        'codigo', 'nombre', 'descripcion',
        'precio_compra', 'precio_venta',
        'stock', 'stock_minimo',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function subcategoria()
    {
        return $this->belongsTo(Subcategoria::class, 'subcategoria_id');
    }

    public function estadoProducto()
    {
        return $this->belongsTo(EstadoProducto::class, 'estado_producto_id');
    }

    public function inventarioMovimientos()
    {
        return $this->hasMany(InventarioMovimiento::class, 'producto_id');
    }

    public function ventaDetalles()
    {
        return $this->hasMany(VentaDetalle::class, 'producto_id');
    }

    public function compraDetalles()
    {
        return $this->hasMany(CompraDetalle::class, 'producto_id');
    }
}
