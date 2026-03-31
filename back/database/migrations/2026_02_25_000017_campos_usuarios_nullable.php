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
        Schema::table('usuarios', function (Blueprint $table){
            $table->string('nombre')->nullable()->change();
            $table->string('apellidos')->nullable()->change();
            $table->string('dni')->nullable()->change();
            $table->string('telefono')->nullable()->change();
            $table->string('direccion')->nullable()->change();
            $table->string('rol')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table){
            $table->string('nombre')->nullable(false)->change();
            $table->string('apellidos')->nullable(false)->change();
            $table->string('dni')->nullable(false)->change();
            $table->string('telefono')->nullable(false)->change();
            $table->string('direccion')->nullable(false)->change();
            $table->string('rol')->nullable(false)->change();
        });
    }
};
