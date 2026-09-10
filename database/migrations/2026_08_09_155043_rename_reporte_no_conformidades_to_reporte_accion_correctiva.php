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
        | RENOMBRAR TABLA
        |--------------------------------------------------------------------------
        */

        Schema::rename(
            'reporte_no_conformidades',
            'reporte_accion_correctiva'
        );

        /*
        |--------------------------------------------------------------------------
        | RENOMBRAR LLAVE PRIMARIA
        |--------------------------------------------------------------------------
        */

        Schema::table('reporte_accion_correctiva', function (Blueprint $table) {
            $table->renameColumn(
                'id',
                'id_reporte_accion_correctiva'
            );
        });
    }

    public function down(): void
    {
        Schema::table('reporte_accion_correctiva', function (Blueprint $table) {
            $table->renameColumn(
                'id_reporte_accion_correctiva',
                'id'
            );
        });

        Schema::rename(
            'reporte_accion_correctiva',
            'reporte_no_conformidades'
        );
    }
};