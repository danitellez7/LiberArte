<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notificaciones_eliminadas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('notificacion_id');

            $table->timestamps();

            //Relaciones
            $table->foreign('usuario_id')
                  ->references('id')->on('usuarios')
                  ->onDelete('cascade');
                
            $table->foreign('notificacion_id')
                  ->references('id')->on('notificaciones')
                  ->onDelete('cascade');

            //Evitamos duplicados 
            $table->unique(['usuario_id', 'notificacion_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificaciones_eliminadas');
    }
};
