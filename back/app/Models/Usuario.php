<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;

class Usuario extends Authenticatable implements MustVerifyEmail{

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
        'verification_token',
        'verification_token_expires_at'
    ];

    //Campos ocultos
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];

    //Conversión automática
    protected $casts = [
        'email_verified_at' => 'datetime',
        'verification_token_expires_at' => 'datetime',
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

        return $this->hasMany(Notificacion::class, 'usuario_id');
    }

    //---------------------------------------------------
    //MÉTODOS DE VERIFICACIÓN DE EMAIL
    //---------------------------------------------------

    //Métodos de verificación

    public function generarTokenVerificacion(){

        $this->verification_token = Str::random(64);
        $this->verification_token_expires_at = now()->addHours(24);
        $this->save();
    }

    public function marcarEmailComoVerificado(){

        $this->email_verified_at = now();
        $this->verification_token = null;
        $this->verification_token_expires_at = null;
        $this->save();
    }
    
}
