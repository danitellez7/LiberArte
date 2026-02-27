<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calendario extends Model
{
        protected $fillable = [
        'titulo',
        'descripcion',
        'tipo',
        'fecha_inicio',
        'fecha_fin',
        'hora_inicio',
        'hora_fin',
        'actividad_id',
        'recurrente',
        'regla_recurrencia',
        'color',
        'ubicacion',
        'estado'
    ];

    //Relación entre calendario y actividad (M:1)
    public function actividad(){

        return $this->belongsTo(Actividad::class, 'actividad_id');
    }

}
