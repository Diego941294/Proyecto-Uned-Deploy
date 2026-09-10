<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // PK de reportes
        Schema::table('reportes', function (Blueprint $table) {
            $table->renameColumn('id', 'id_reportes');
        });

        // FK en reporte_detalles
        Schema::table('reporte_detalles', function (Blueprint $table) {
            $table->renameColumn(
                'reporte_id',
                'id_reportes'
            );
        });

        // FK en reporte_no_conformidades
        Schema::table('reporte_no_conformidades', function (Blueprint $table) {
            $table->renameColumn(
                'reporte_id',
                'id_reportes'
            );
        });
    }

    public function down(): void
    {
        Schema::table('reporte_no_conformidades', function (Blueprint $table) {
            $table->renameColumn(
                'id_reportes',
                'reporte_id'
            );
        });

        Schema::table('reporte_detalles', function (Blueprint $table) {
            $table->renameColumn(
                'id_reportes',
                'reporte_id'
            );
        });

        Schema::table('reportes', function (Blueprint $table) {
            $table->renameColumn(
                'id_reportes',
                'id'
            );
        });
    }
};