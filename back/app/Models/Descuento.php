<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Descuento extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo',
        'valor',
        'unidad',
        'condicion_minima',
        'estado',
        'fecha_inicio',
        'fecha_fin'
    ];
}
