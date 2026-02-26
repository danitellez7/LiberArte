<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreciosTable extends Migration{

    public function up(){
        
        Schema::create('precios', function (Blueprint $table) {
            // Primary key
            $table->id();

            // Relación: Una actividad puede tener varios precios
            $table->foreignId('actividad_id')
                  ->constrained('actividades')
                  ->cascadeOnDelete();

            /*Tipo de precio: 
            * - Mensual_individual
            * - Mensual_dos_familiares
            * - Mensual_tres_familiares
            * - Sesion_suelta 
            */
            $table->string('tipo');

            // Precio en euros 
            $table->decimal('precio', 8, 2);

            // Estado
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');

            // created_at y updated_at
            $table->timestamps();
        });
    }

    public function down(){

        // Elimina la tabla si existe
        Schema::dropIfExists('precios');
    }
}
