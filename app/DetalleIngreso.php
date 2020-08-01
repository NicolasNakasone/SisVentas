<?php

namespace SisVentas;

use Illuminate\Database\Eloquent\Model;

class DetalleIngreso extends Model
{
    protected $table= "detalle_ingreso";

    protected $primaryKey= "iddetalle_ingreso";

    public $timestamps= false;

    protected $fillable= [
        'iddetalle_ingreso',
        'id_ingreso',
        'id_articulo',
        'cantidad',
        'precio_compra',
        'precio_venta'
    ];

    protected $guarded= [

    ];
}
