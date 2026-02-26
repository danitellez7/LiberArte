<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagosTable extends Migration{

    public function up(){

        Schema::create('pagos', function (Blueprint $table) {
            // Primary key
            $table->id();

            // Tutor que realiza el pago
            $table->foreignId('tutor_id')
                  ->constrained('usuarios')
                  ->cascadeOnDelete();

            // Mes al que corresponde el pago (formato YYYY-MM)
            $table->string('mes');

            // Total antes de descuentos
            $table->decimal('total_sin_descuento', 8, 2);

            // Descuento aplicado
            $table->decimal('descuento_aplicado', 8, 2)->default(0);

            // Total final después del descuento
            $table->decimal('total_final', 8, 2);

            // Estado
            $table->enum('estado', ['pendiente', 'pagado', 'fallido'])
                  ->default('pendiente');

            // Método de pago
            $table->string('metodo_pago')->nullable();

            // Fecha en la que se realizó el pago
            $table->date('fecha_pago')->nullable();

            // Notas 
            $table->text('notas')->nullable();

            // created_at y updated_at
            $table->timestamps();
        });
    }

    public function down(){

        //Elimina la tabla si existe
        Schema::dropIfExists('pagos');
    }
}
