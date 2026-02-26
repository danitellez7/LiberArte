<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDescuentosTable extends Migration{

    public function up(){

        Schema::create('descuentos', function (Blueprint $table) {
            // Primary key
            $table->id();

            // Nombre del descuento
            $table->string('nombre');

            // Descripción del descuento
            $table->text('descripcion')->nullable();

            // Tipo de descuento 
            $table->string('tipo');

            // Valor del descuento 
            $table->decimal('valor', 5, 2);

            // Unidad del valor
            $table->enum('unidad', ['porcentaje', 'euros'])->default('porcentaje');

            // Condición mínima - 2 disciplinas
            $table->integer('condicion_minima')->nullable();

            // Estado 
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');

            // Fechas 
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();

            // created_at y updated_at
            $table->timestamps();
        });
    }

    public function down(){

        //Elimina la tabla si existe
        Schema::dropIfExists('descuentos');
    }
}
