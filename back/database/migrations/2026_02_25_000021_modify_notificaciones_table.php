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
        Schema::table('notificaciones', function (Blueprint $table) {
            
            //Renombramos usuario_id por tutor_id
            if(Schema::hasColumn('notificaciones', 'usuario_id')) {
                $table->renameColumn('usuario_id', 'tutor_id');
            }

            //Hacer el tutor nullable
            if(Schema::hasColumn('notificaciones', 'tutor_id')) {
                $table->unsignedBigInteger('tutor_id')->nullable()->change();
            }

            //Añadir creado por (empleado/admin que crea la notificación)
            if(!Schema::hasColumn('notificaciones', 'creado_por')) {
                $table->unsignedBigInteger('creado_por')->after('tutor_id');
            }

            //Añadir el subtipo
            if(Schema::hasColumn('notificaciones', 'tipo')) {
                $table->string('subtipo')->nullable()->after('tipo');
            }

            //Convertir tipo en ENUM
            if(Schema::hasColumn('notificaciones', 'tipo')) {
                $table->enum('tipo', [
                    'general',
                    'individual',
                    'evento',
                    'clase',
                    'aviso'
                ])->change();
            }

            //FOREIGN KEYS

            //tutor_id a usuarios.id
            if(Schema::hasColumn('notificaciones', 'tutor_id')) {
                $table->foreign('tutor_id')
                      ->references('id')
                      ->on('usuarios')
                      ->nullOnDelete();
            }

            //creado_por a usuarios.id
            if(Schema::hasColumn('notificaciones', 'creado_por')) {
                $table->foreign('creado_por')
                      ->references('id')
                      ->on('usuarios')
                      ->cascadeOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notificaciones', function (Blueprint $table) {

            //ELIMINAR FOREIGN KEYS
            if(Schema::hasColumn('notificaciones', 'tutor_id')) {
                $table->dropForeign(['tutor_id']);
            }

            if(Schema::hasColumn('notificaciones', 'creado_por')) {
                $table->dropForeign(['creado_por']);
            }
            
            //Revertir renombrado
             if(Schema::hasColumn('notificaciones', 'tutor_id')) {
                $table->renameColumn('tutor_id', 'usuario_id');
            }

            //Quitar creado_por
            if(Schema::hasColumn('notificaciones', 'creado_por')) {
                $table->dropColumn('creado_por');
            }

            //Quitar subtipo
            if(Schema::hasColumn('notificaciones', 'subtipo')) {
                $table->dropColumn('subtipo');
            }

            //Volver a tipo string
            if(Schema::hasColumn('notificaciones', 'tipo')) {
                $table->string('tipo')->change();
            }
        });
    }
};
