<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model{

    // Añadimos los campos 
    protected $fillable = [
        'nombre',
        'apellidos',
        'dni',
        'telefono',
        'direccion',
        'email',
        'password',
        'rol'
    ];

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

        return $this->hasMany(Pago::class);
    }

    //Relación entre usuario y ficheros (1:M)
    public function ficheros(){

        return $this->hasMany(Fichero::class, 'tutor_id');
    }

    //Relación entre usuario y actividades (1:M)
    public function actividades(){

        return $this->hasMany(Actividad::class, 'empleado_id');
    }

    //Relación entre usuario y notificaciones (1:M)
    public function notificaciones(){

        return $this->hasMany(Notificacion::class);
    }
    
}
