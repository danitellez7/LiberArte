<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInscripcionesTable extends Migration{

    public function up()
    {
        Schema::create('inscripciones', function (Blueprint $table) {
            //Primary key
            $table->id();

            // Niño inscrito
            $table->foreignId('nino_id')
                  ->constrained('ninos')
                  ->cascadeOnDelete();

            // Actividad a la que se inscribe
            $table->foreignId('actividad_id')
                  ->constrained('actividades')
                  ->cascadeOnDelete();

            // Precio aplicado 
            $table->foreignId('precio_id')
                  ->constrained('precios')
                  ->cascadeOnDelete();

            // Fecha en la que se inscribe
            $table->date('fecha_inscripcion');

            // Estado
            $table->enum('estado', ['activa', 'baja', 'pendiente'])
                  ->default('activa');

            // Fecha de baja
            $table->date('fecha_baja')->nullable();

            // Observaciones
            $table->text('observaciones')->nullable();

            // created_at y updated_at
            $table->timestamps();
        });
    }

    public function down(){

        // Elimina la tabla si existe
        Schema::dropIfExists('inscripciones');
    }
}
