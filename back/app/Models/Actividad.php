<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Fichero;

class Actividad extends Model
{
        protected $table = 'actividades';

        protected $fillable = [
        'nombre',
        'descripcion',
        'area_artistica',
        'edad_minima',
        'edad_maxima',
        'duracion',
        'imagen',
        'estado'
    ];

    //-------------------------------------------------------
    //RELACIONES
    //-------------------------------------------------------

    //Relacion entre actividad y usuario (1:M)
    public function empleado(){

        return $this->belongsTo(Usuario::class, 'empleado_id');
    }

    //Relación entre actividad e inscripciones (1:M)
    public function inscripciones(){

        return $this->hasMany(Inscripcion::class, 'actividad_id');
    }

    //Relación entre actividad y niños (N:M)
    public function ninos(){

        return $this->belongsToMany(Nino::class, 'inscripciones', 'actividad_id', 'nino_id');
    }
}
