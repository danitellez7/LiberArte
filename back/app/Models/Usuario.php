<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Inscripcion;
use App\Models\Actividad;

class Usuario extends Authenticatable{

    use HasApiTokens, HasFactory, Notifiable;

    // Añadimos los campos 
    protected $fillable = [
        'nombre',
        'apellidos',
        'dni',
        'telefono',
        'direccion',
        'email',
        'password',
        'rol',
        'contrato_pdf',
        'reset_token',
        'reset_token_expires_at',
    ];

    //Campos ocultos
    protected $hidden = [
        'password',
        'remember_token',
        'reset_token',
    ];

    //Conversión automática
    protected $casts = [
        'reset_token_expires_at' => 'datetime',
    ];

    //-------------------------------------------------------
    //RELACIONES
    //-------------------------------------------------------

    //Relación entre usuario y niños (tutor principal) (1:M)
    public function ninosTutor(){ 
        
        return $this->hasMany(Nino::class, 'tutor_id'); 
    }

    // Relación entre usuario y niños (tutores secundarios) (N:M)
    public function ninos(){

        return $this->belongsToMany(Nino::class, 'nino_usuario');
    }

    //Relación entre usuario y pagos (1:M)
    public function pagos(){

        return $this->hasMany(Pago::class, 'tutor_id');
    }

    //Relación entre usuario y actividades (1:M)
    public function actividades(){

        return $this->hasManyThrough(
            \App\Models\Actividad::class,
            \App\Models\Inscripcion::class,
            'tutor_id',
            'id',
            'id',
            'actividad_id'
        );
    }
    //Relación con empleado 
    public function clasesEmpleado(){

        return $this->hasMany(ClaseEmpleado::class, 'empleado_id');
    }
    
}
