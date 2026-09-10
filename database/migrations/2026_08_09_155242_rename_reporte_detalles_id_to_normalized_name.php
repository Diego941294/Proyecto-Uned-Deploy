<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reporte_detalles', function (Blueprint $table) {
            $table->renameColumn(
                'id',
                'id_reporte_detalles'
            );
        });
    }

    public function down(): void
    {
        Schema::table('reporte_detalles', function (Blueprint $table) {
            $table->renameColumn(
                'id_reporte_detalles',
                'id'
            );
        });
    }
};