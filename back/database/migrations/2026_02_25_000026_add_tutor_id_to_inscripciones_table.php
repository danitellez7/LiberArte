<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('inscripciones', function (Blueprint $table) {
        $table->Foreign('tutor_id')
              ->references('id')
              ->on('usuarios')
              ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('inscripciones', function (Blueprint $table) {
            $table->dropForeign(['tutor_id']);
        });
    }
};
