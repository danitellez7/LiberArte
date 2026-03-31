<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nino extends Model
{
    protected $fillable = [
        'tutor_id', 
        'nombre', 
        'apellidos', 
        'fecha_nacimiento', 
        'sexo', 
        'alergias', 
        'observaciones'
    ];

    //-------------------------------------------------------
    //RELACIONES
    //-------------------------------------------------------

    //Relación entre niño y tutor (1:M)
    public function tutor(){

        return $this->belongsTo(Usuario::class, 'tutor_id');
    }

    //Relación entre niño y tutor secundario (N:M)
    public function usuarios(){

        return $this->belongsToMany(Usuario::class, 'nino_usuario');
    }

    //Relación entre niño e incripciones (1:M)
    public function inscripciones(){

        return $this->hasMany(Inscripcion::class, 'nino_id');
    }

    //Relación entre niño y ficheros (1:M)
    public function ficheros(){

        return $this->hasMany(Fichero::class, 'nino_id');
    }

    //Relación entre niño y actividades (N:M)
    public function actividades(){

        return $this->belongsToMany(Actividad::class, 'inscripciones', 'nino_id', 'actividad_id');
    }

}
