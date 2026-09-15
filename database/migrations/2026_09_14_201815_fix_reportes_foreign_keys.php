<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Eliminar las FK antiguas
        |--------------------------------------------------------------------------
        */

        Schema::table('reportes', function (Blueprint $table) {
            $table->dropForeign(['id_areas']);
            $table->dropForeign(['id_users']);
            $table->dropForeign(['id_usuario_aprobador']);
        });

        /*
        |--------------------------------------------------------------------------
        | Crear las FK normalizadas
        |--------------------------------------------------------------------------
        */

        Schema::table('reportes', function (Blueprint $table) {

            // Área del reporte
            $table->foreign('id_areas')
                ->references('id_areas')
                ->on('areas')
                ->restrictOnDelete();

            // Usuario creador
            $table->foreign('id_users')
                ->references('id_users')
                ->on('users')
                ->restrictOnDelete();

            // Usuario que aprueba
            $table->foreign('id_usuario_aprobador')
                ->references('id_users')
                ->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('reportes', function (Blueprint $table) {
            $table->dropForeign(['id_areas']);
            $table->dropForeign(['id_users']);
            $table->dropForeign(['id_usuario_aprobador']);
        });

        Schema::table('reportes', function (Blueprint $table) {

            $table->foreign('id_areas')
                ->references('id_areas')
                ->on('areas')
                ->restrictOnDelete();

            $table->foreign('id_users')
                ->references('id_users')
                ->on('users')
                ->restrictOnDelete();

            $table->foreign('id_usuario_aprobador')
                ->references('id_users')
                ->on('users')
                ->nullOnDelete();
        });
    }
};