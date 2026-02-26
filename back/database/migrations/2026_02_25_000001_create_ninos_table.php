<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNinosTable extends Migration{
    
    public function up(){

        Schema::create('ninos', function (Blueprint $table) {
            // primary key
            $table->id();

            // Tutor del niño 
            // Si se borra el tutor, se borran también sus niños
            $table->foreignId('tutor_id')
                  ->constrained('usuarios')
                  ->cascadeOnDelete();

            // Nombre del niño, apellidos y fecha de nacimiento
            $table->string('nombre');
            $table->string('apellidos');
            $table->date('fecha_nacimiento');

            // Sexo del niño: masculino, femenino u otro (opcional)
            $table->enum('sexo', ['masculino', 'femenino', 'otro'])->nullable();

            // Alergias del niño (opcional)
            $table->text('alergias')->nullable();

            // Observaciones (opcional)
            $table->text('observaciones')->nullable();

            // created_at y updated_at
            $table->timestamps();
        });
    }

    public function down(){

        // Elimina la tabla si existe
        Schema::dropIfExists('ninos');
    }
}
