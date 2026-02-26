<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendariosTable extends Migration{

    public function up(){

        Schema::create('calendarios', function (Blueprint $table) {
            // Primary key
            $table->id();

            // Título del evento o sesión
            $table->string('titulo');

            // Descripción
            $table->text('descripcion')->nullable(); 

            // Tipo: evento especial o sesión de actividad
            $table->enum('tipo', ['evento', 'sesion']);

            // Fechas y horas
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fin')->nullable();

            // Relación con actividad
            $table->foreignId('actividad_id')
                  ->nullable()
                  ->constrained('actividades')
                  ->nullOnDelete();

            // Repetición si fuera un evento o actividad recurrente
            $table->boolean('recurrente')->default(false);
            $table->string('regla_recurrencia')->nullable();

            // Color para mostrarlo en el calendario
            $table->string('color')->nullable();

            // Ubicación
            $table->string('ubicacion')->nullable();

            // Estado
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');

            $table->timestamps();
        });
    }

    public function down(){

        //Elimina la tabla si existe
        Schema::dropIfExists('calendarios');
    }
}
