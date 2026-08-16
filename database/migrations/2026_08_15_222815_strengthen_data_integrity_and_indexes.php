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
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | INFRAESTRUCTURAS
        |--------------------------------------------------------------------------
        | Cambiar la política de eliminación:
        | areas -> infraestructuras
        |
        | Evitamos CASCADE para proteger información relacionada.
        */

        Schema::table('infraestructuras', function (Blueprint $table) {
            $table->dropForeign(['id_areas']);
        });

        Schema::table('infraestructuras', function (Blueprint $table) {
            $table->foreign('id_areas')
                ->references('id_areas')
                ->on('areas')
                ->restrictOnDelete();
        });


        /*
        |--------------------------------------------------------------------------
        | CHECK ITEMS
        |--------------------------------------------------------------------------
        | Cada Check Item debe pertenecer obligatoriamente
        | a una infraestructura.
        */

        Schema::table('check_items', function (Blueprint $table) {
            $table->dropForeign(['id_infraestructuras']);
        });

        /*
         * SQLite puede requerir recreación interna de la tabla
         * para modificar nullability.
         */
        Schema::table('check_items', function (Blueprint $table) {
            $table->unsignedBigInteger('id_infraestructuras')
                ->nullable(false)
                ->change();
        });

        Schema::table('check_items', function (Blueprint $table) {
            $table->foreign('id_infraestructuras')
                ->references('id_infraestructuras')
                ->on('infraestructuras')
                ->restrictOnDelete();
        });


        /*
        |--------------------------------------------------------------------------
        | ÍNDICES - REPORTES
        |--------------------------------------------------------------------------
        */

        Schema::table('reportes', function (Blueprint $table) {
            $table->index(
                'id_users',
                'idx_reportes_id_users'
            );

            $table->index(
                'id_areas',
                'idx_reportes_id_areas'
            );

            $table->index(
                'id_usuario_aprobador',
                'idx_reportes_id_usuario_aprobador'
            );

            $table->index(
                'fecha',
                'idx_reportes_fecha'
            );

            $table->index(
                'estado',
                'idx_reportes_estado'
            );
        });


        /*
        |--------------------------------------------------------------------------
        | ÍNDICES - CHECK ITEMS
        |--------------------------------------------------------------------------
        */

        Schema::table('check_items', function (Blueprint $table) {
            $table->index(
                'id_infraestructuras',
                'idx_check_items_id_infraestructuras'
            );
        });


        /*
        |--------------------------------------------------------------------------
        | ÍNDICES - REPORTE ACCIÓN CORRECTIVA
        |--------------------------------------------------------------------------
        */

        Schema::table('reporte_accion_correctiva', function (Blueprint $table) {
            $table->index(
                'id_reportes',
                'idx_reporte_accion_correctiva_id_reportes'
            );
        });


        /*
        |--------------------------------------------------------------------------
        | ÍNDICES - REPORTE DETALLES
        |--------------------------------------------------------------------------
        */

        Schema::table('reporte_detalles', function (Blueprint $table) {
            $table->index(
                'id_check_items',
                'idx_reporte_detalles_id_check_items'
            );
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | ELIMINAR ÍNDICES
        |--------------------------------------------------------------------------
        */

        Schema::table('reporte_detalles', function (Blueprint $table) {
            $table->dropIndex(
                'idx_reporte_detalles_id_check_items'
            );
        });

        Schema::table('reporte_accion_correctiva', function (Blueprint $table) {
            $table->dropIndex(
                'idx_reporte_accion_correctiva_id_reportes'
            );
        });

        Schema::table('check_items', function (Blueprint $table) {
            $table->dropIndex(
                'idx_check_items_id_infraestructuras'
            );
        });

        Schema::table('reportes', function (Blueprint $table) {
            $table->dropIndex('idx_reportes_id_users');
            $table->dropIndex('idx_reportes_id_areas');
            $table->dropIndex('idx_reportes_id_usuario_aprobador');
            $table->dropIndex('idx_reportes_fecha');
            $table->dropIndex('idx_reportes_estado');
        });


        /*
        |--------------------------------------------------------------------------
        | RESTAURAR CHECK ITEMS
        |--------------------------------------------------------------------------
        */

        Schema::table('check_items', function (Blueprint $table) {
            $table->dropForeign(['id_infraestructuras']);
        });

        Schema::table('check_items', function (Blueprint $table) {
            $table->unsignedBigInteger('id_infraestructuras')
                ->nullable()
                ->change();
        });

        Schema::table('check_items', function (Blueprint $table) {
            $table->foreign('id_infraestructuras')
                ->references('id_infraestructuras')
                ->on('infraestructuras')
                ->nullOnDelete();
        });


        /*
        |--------------------------------------------------------------------------
        | RESTAURAR INFRAESTRUCTURAS
        |--------------------------------------------------------------------------
        */

        Schema::table('infraestructuras', function (Blueprint $table) {
            $table->dropForeign(['id_areas']);
        });

        Schema::table('infraestructuras', function (Blueprint $table) {
            $table->foreign('id_areas')
                ->references('id_areas')
                ->on('areas')
                ->cascadeOnDelete();
        });
    }
};