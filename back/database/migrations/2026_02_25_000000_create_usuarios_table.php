<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration{
    public function up(){

        Schema::create('usuarios', function (Blueprint $table) {
            // Primary key
            $table->id();

            // Datos personales
            $table->string('nombre');
            $table->string('apellidos');
            $table->string('dni', 15)->nullable()->unique();
            $table->string('telefono')->nullable();
            $table->string('direccion')->nullable();

            // Email y contraseña
            $table->string('email')->unique();
            $table->string('password');

            // Roles: tutor, admin, empleado
            $table->enum('rol', ['tutor', 'admin', 'empleado'])->default('tutor');

            $table->timestamps();
        });
    }

    public function down(){

        // Elimina la tabla si existe
        Schema::dropIfExists('usuarios');
    }
}

