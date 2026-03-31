<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;
use App\Models\Inscripcion;
use App\Models\PagoInscripcion;

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

    //-------------------------------------------------------
    //RELACIONES
    //-------------------------------------------------------

    //Relación entre pago y Tutor (M:1)
    public function tutor(){

        return $this->belongsTo(Usuario::class, 'tutor_id');
    }

    //Relación entre pago e inscripción
    public function inscripcionesCobradas(){
        return $this->belongsToMany(Inscripcion::class, 'pago_inscripciones')
                    ->using(PagoInscripcion::class)
                    ->withPivot('importe')
                    ->withTimestamps();
    }
}
