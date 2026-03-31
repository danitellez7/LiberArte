<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PagoInscripcion extends Pivot 
{
    protected $table = 'pago_inscripciones';

    protected $fillable = [
        'pago_id',
        'inscripcion_id',
        'importe',
    ];

}
