<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Nino;
use App\Models\Actividad;
use App\Models\Precio;
use App\Models\Usuario;
use App\Models\Pago;
use App\Models\PagoInscripcion;

class Inscripcion extends Model
{
        protected $table = 'inscripciones';
        
        protected $fillable = [
        'nino_id',
        'actividad_id',
        'precio_id',
        'fecha_inscripcion',
        'fecha_fin',
        'tutor_id',
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

    //Tutor que realizó la inscripción (M:1)
    public function tutor(){

        return $this->belongsTo(Usuario::class, 'tutor_id');
    }

    //Relacion entre inscripción y pago
    public function pagos(){
        return $this->belongsToMany(Pago::class, 'pago_inscripciones')
                    ->using(PagoInscripcion::class)
                    ->withPivot('importe')
                    ->withTimestamps();
    }
}
