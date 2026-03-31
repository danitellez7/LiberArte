<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
        protected $table = 'inscripciones';
        
        protected $fillable = [
        'nino_id',
        'actividad_id',
        'precio_id',
        'fecha_inscripcion',
        'estado',
        'fecha_baja',
        'observaciones'
    ];

    //-------------------------------------------------------
    //RELACIONES
    //-------------------------------------------------------

    //Relación entre inscripción y niños (M:1)
    public function nino(){

        return $this->belongsTo(Nino::class, 'nino_id');
    }

    //Relación entre inscripción y actividad (M:1)
    public function actividad(){

        return $this->belongsTo(Actividad::class, 'actividad_id');
    }

    //Relación entre inscripción y precio (M:1)
    public function precio(){

        return $this->belongsTo(Precio::class, 'precio_id');
    }

    //Relacion entre inscripción y pago
    public function pagos(){
        return $this->belongsToMany(Pago::class, 'pago_inscripciones')
                    ->using(PagoInscripcion::class)
                    ->withPivot('importe')
                    ->withTimestamps();
    }
}
