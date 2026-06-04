<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaseEmpleado extends Model
{
    use HasFactory;

    protected $table = 'clases_empleado';

    protected $fillable = [
        'empleado_id',
        'nino_id',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'estado',
    ];


    //Relación con empleado (usuario)
    public function empleado(){

        return $this->belongsTo(Usuario::class, 'empleado_id');
    }

    //Relación con niño
    public function nino(){
        return $this->belongsTo(Nino::class, 'nino_id');
    }
}
