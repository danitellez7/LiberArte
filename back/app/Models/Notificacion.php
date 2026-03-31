<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

    //Para poder crear notificaciones 
    class Notificacion extends Model
    {
        protected $fillable = [
        'usuario_id',
        'titulo',
        'mensaje',
        'leida',
        'tipo'
    ];

    //-------------------------------------------------------
    //RELACIONES
    //-------------------------------------------------------

    //Relación entre notificaciones y usuario (1:1)
    public function usuario(){

        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

}
