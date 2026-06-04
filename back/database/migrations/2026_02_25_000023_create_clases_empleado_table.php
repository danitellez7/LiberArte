<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClasesEmpleadoTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('clases_empleado', function (Blueprint $table) {
            $table->id();

            $table->foreignId('empleado_id')
                  ->constrained('usuarios')
                  ->onDelete('cascade');

            $table->foreignId('nino_id')
                  ->constrained('ninos')
                  ->onDelete('cascade');

            $table->date('fecha');
            $table->time('hora_inicio');
            $table->time('hora_fin');

            $table->enum('estado', ['pendiente', 'confirmada', 'cancelada'])
                  ->default('pendiente');
                  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('clases_empleado');
    }
};
