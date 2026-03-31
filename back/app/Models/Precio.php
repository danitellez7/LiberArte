<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Precio extends Model
{
    protected $fillable = [
        'actividad_id',
        'tipo',
        'precio',
        'estado'
    ];

    //-------------------------------------------------------
    //RELACIONES
    //-------------------------------------------------------

    //Relación entre precio y actividad (M:1)
    public function actividad(){

        return $this->belongsTo(Actividad::class, 'actividad_id');
    }

    //Relación entre precio e inscripciones (M:1)
    public function inscripciones(){

        return $this->hasMany(Inscripcion::class, 'precio_id');
    }

}
