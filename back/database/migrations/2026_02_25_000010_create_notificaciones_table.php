<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificacionesTable extends Migration{
    
    public function up(){

        Schema::create('notificaciones', function (Blueprint $table) {
            //Primary key
            $table->id();

            //Relacion
            $table->foreignId('usuario_id')
                ->constrained('usuarios')
                ->onDelete('cascade');

            //Título
            $table->string('titulo');

            //Notificacion
            $table->text('mensaje');

            //Estado y tipo
            $table->boolean('leida')->default(false);
            $table->string('tipo')->nullable();

            $table->timestamps();
        });
    }

    public function down(){

        //Elimina la tabla si existe
        Schema::dropIfExists('notificaciones');
    }

}