<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNinoUsuarioTable extends Migration{

    public function up(){

        Schema::create('nino_usuario', function (Blueprint $table) {
            // Primary key
            $table->id();

            // Relaciones
            $table->foreignId('nino_id')
                  ->constrained('ninos')
                  ->onDelete('cascade');

            $table->foreignId('usuario_id')
                  ->constrained('usuarios')
                  ->onDelete('cascade');

            // Tipo (padre, madre, tutor legal, autorizado…)
            $table->string('tipo')->nullable();

            // Responsable económico
            $table->boolean('responsable_economico')->default(false);

            $table->timestamps();
        });
    }

    public function down(){

        // Elimina la tabla si no existe
        Schema::dropIfExists('nino_usuario');
    }
}
