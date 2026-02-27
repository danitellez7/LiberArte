<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NinoUsuario extends Model
{
    protected $fillable = [
        'nino_id',
        'usuario_id',
        'tipo',
        'responsable_economico'
    ];

    //Relación con niño
    public function nino(){

        return $this->belongsTo(Nino::class, 'nino_id');
    }

    //Relacion con Usuario
    public function usuario(){

        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
