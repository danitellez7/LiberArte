<?php

namespace App\Models;

use App\Models\Usuario;

use Illuminate\Database\Eloquent\Model;

    //Para poder crear notificaciones 
    class Notificacion extends Model
    {

        protected $table = 'notificaciones';
        
        protected $fillable = [
        'tutor_id',
        'titulo',
        'mensaje',
        'subtipo',
        'leida',
        'tipo',
        'creado_por'
    ];

    //-------------------------------------------------------
    //RELACIONES
    //-------------------------------------------------------

    //Relación entre notificaciones y usuario (1:1)
    public function tutor(){

        return $this->belongsTo(Usuario::class, 'tutor_id');
    }

    //Relación entre notificaciones y usuario creador(1:1)
    public function creador(){
        return $this->belongsTo(Usuario::class, 'creado_por');
    }
}
