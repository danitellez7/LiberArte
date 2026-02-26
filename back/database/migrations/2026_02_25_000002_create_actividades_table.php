<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActividadesTable extends Migration{

    public function up(){

        Schema::create('actividades', function (Blueprint $table) {
            //Primary key
            $table->id();

            // Nombre de la actividad
            $table->string('nombre');

            // Breve descripción de la actividad
            $table->text('descripcion');

            // Área artística: teatro, danza, pintura, cerámica, música, canto
            $table->string('area_artistica');

            // Edad mínima y máxima
            $table->integer('edad_minima')->nullable();
            $table->integer('edad_maxima')->nullable();

            // Duración 
            $table->string('duracion')->nullable();

            // Estado de la actividad
            $table->enum('estado', ['activa', 'inactiva'])->default('activa');

            // Imagen de la actividad
            $table->string('imagen')->nullable();

            // created_at y updated_at
            $table->timestamps();
        });
    }

    public function down(){
        
        // Elimina la tabla si existe
        Schema::dropIfExists('actividades');
    }
}
