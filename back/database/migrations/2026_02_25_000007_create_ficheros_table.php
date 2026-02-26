<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFicherosTable extends Migration{

    public function up(){

        Schema::create('ficheros', function (Blueprint $table) {
            // Primary key
            $table->id();

            // Nombre del arhivo
            $table->string('nombre_original');

            // Ruta donde se almacena
            $table->string('ruta');

            // Tipo (pdf, jpg, png, etc.)
            $table->string('tipo_mime')->nullable();

            // Tamaño del archivo
            $table->integer('tamano')->nullable();

            // Categoría del archivo (actividad, niño, tutor, general)
            $table->string('categoria')->nullable();

            // Relaciones 
            // Con actividades
            $table->foreignId('actividad_id')
                  ->nullable()
                  ->constrained('actividades')
                  ->nullOnDelete();

            // Con los niños
            $table->foreignId('nino_id')
                  ->nullable()
                  ->constrained('ninos')
                  ->nullOnDelete();

            // Con el tutor del niño
            $table->foreignId('tutor_id')
                  ->nullable()
                  ->constrained('usuarios')
                  ->nullOnDelete();

            // Descripción 
            $table->text('descripcion')->nullable();

            // Estado
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');

            // created_at y updated_at
            $table->timestamps();
        });
    }

    public function down(){

        //Elimina la tabla si existe
        Schema::dropIfExists('ficheros');
    }
}
