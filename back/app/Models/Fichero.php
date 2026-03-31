<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fichero extends Model
{
    protected $fillable = [
        'nombre_original',
        'ruta',
        'tipo_mime',
        'tamano',
        'categoria',
        'actividad_id',
        'nino_id',
        'tutor_id',
        'descripcion',
        'estado'
    ];

    //-------------------------------------------------------
    //RELACIONES
    //-------------------------------------------------------

    //Relación entre fichero y actividad (M:1)
    public function actividad(){

        return $this->belongsTo(Actividad::class, 'actividad_id');
    }

    //Relación entre fichero y niño (M:1)
    public function nino(){

        return $this->belongsTo(Nino::class, 'nino_id');
    }

    //Relación entre fichero y tutor (M:1)
    public function tutor(){

        return $this->belongsTo(Usuario::class, 'tutor_id');
    }
}
