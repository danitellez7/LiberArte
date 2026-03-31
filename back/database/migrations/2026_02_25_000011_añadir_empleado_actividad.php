<?php

use Illuminate\Database\Migrations\Migration; 
use Illuminate\Database\Schema\Blueprint; 
use Illuminate\Support\Facades\Schema;

class AñadirEmpleadoActividad extends Migration{

    public function up(){

        Schema::table('actividades', function(Blueprint $table){
            $table->foreignId('empleado_id')
                  ->nullable()
                  ->constrained('usuarios')
                  ->nullOnDelete();
        });
    }

    public function down(){

        Schema::table('actividades', function(Blueprint $table){
            $table->dropForeign(['empleado_id']);
            $table->dropColumn('empleado_id');
        });
    }
}
