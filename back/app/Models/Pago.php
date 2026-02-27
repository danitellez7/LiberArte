<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model{

    protected $fillable = [
        'tutor_id',
        'mes', 
        'total_sin_descuento',
        'descuento_aplicado',
        'total_final',
        'estado',
        'metodo_pago',
        'fecha_pago',
        'notas'
    ];

    //Relación entre pago y Tutor (M:1)
    public function tutor(){

        return $this->belongsTo(Usuario::class, 'tutor_id');
    }
}
