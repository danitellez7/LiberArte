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
        Schema::create('pago_inscripciones', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('pago_id');
            $table->unsignedBigInteger('inscripcion_id');

            $table->decimal('importe', 8, 2);
            
            $table->timestamps();

            //Foreign Keys
            $table->foreign('pago_id')->references('id')->on('pagos')->onDelete('cascade');
            $table->foreign('inscripcion_id')->references('id')->on('inscripciones')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pago_inscripciones');
    }
};
