<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reporte_historial_estados', function (Blueprint $table) {

            $table->id('id_reporte_historial_estados');

            $table->unsignedBigInteger('id_reportes');

            $table->unsignedBigInteger('id_users')
                ->nullable();

            $table->string('estado_anterior')
                ->nullable();

            $table->string('estado_nuevo');

            $table->text('comentario')
                ->nullable();

            $table->timestamps();

            /*
             * El historial no debe desaparecer
             * accidentalmente por eliminar un reporte.
             */
            $table->foreign('id_reportes')
                ->references('id_reportes')
                ->on('reportes')
                ->restrictOnDelete();

            /*
             * Si se elimina el usuario, conservamos
             * el historial pero dejamos el usuario NULL.
             */
            $table->foreign('id_users')
                ->references('id_users')
                ->on('users')
                ->nullOnDelete();

            $table->index(
                'id_reportes',
                'idx_historial_id_reportes'
            );

            $table->index(
                'id_users',
                'idx_historial_id_users'
            );

            $table->index(
                'estado_nuevo',
                'idx_historial_estado_nuevo'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reporte_historial_estados');
    }
};