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
        | CHECK ITEMS
        |--------------------------------------------------------------------------
        | Se elimina area_id porque el área se obtiene mediante:
        |
        | check_items.infraestructura_id
        |          ↓
        | infraestructuras.area_id
        |          ↓
        | areas.id
        */

        Schema::table('check_items', function (Blueprint $table) {
            $table->dropForeign(['area_id']);
            $table->dropColumn('area_id');
        });

        /*
        |--------------------------------------------------------------------------
        | REPORTE DETALLES
        |--------------------------------------------------------------------------
        | Se eliminan campos antiguos que ya no forman parte
        | del modelo actual.
        */

        Schema::table('reporte_detalles', function (Blueprint $table) {
            $table->dropColumn([
                'lunes',
                'martes',
                'miercoles',
                'jueves',
                'viernes',
                'sabado',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('check_items', function (Blueprint $table) {
            $table->foreignId('area_id')
                ->constrained('areas')
                ->cascadeOnDelete();
        });

        Schema::table('reporte_detalles', function (Blueprint $table) {
            $table->string('lunes')->nullable();
            $table->string('martes')->nullable();
            $table->string('miercoles')->nullable();
            $table->string('jueves')->nullable();
            $table->string('viernes')->nullable();
            $table->string('sabado')->nullable();
        });
    }
};