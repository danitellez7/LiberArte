<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificacionEliminada extends Model
{
    protected $table = 'notificaciones_eliminadas';

    protected $fillable = [
        'usuario_id',
        'notificacion_id',
    ];

    public $timestamps = true;
}
