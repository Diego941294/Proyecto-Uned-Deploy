<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Renombrar la PK de areas y las FK que apuntan hacia ella.
     *
     * areas.id                    -> areas.id_areas
     * infraestructuras.area_id    -> infraestructuras.id_areas
     * reportes.area_id            -> reportes.id_areas
     */
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | AREAS
        |--------------------------------------------------------------------------
        */
        Schema::table('areas', function (Blueprint $table) {
            $table->renameColumn('id', 'id_areas');
        });

        /*
        |--------------------------------------------------------------------------
        | INFRAESTRUCTURAS
        |--------------------------------------------------------------------------
        */
        Schema::table('infraestructuras', function (Blueprint $table) {
            $table->renameColumn('area_id', 'id_areas');
        });

        /*
        |--------------------------------------------------------------------------
        | REPORTES
        |--------------------------------------------------------------------------
        */
        Schema::table('reportes', function (Blueprint $table) {
            $table->renameColumn('area_id', 'id_areas');
        });
    }

    /**
     * Revertir los nombres en caso de rollback.
     */
    public function down(): void
    {
        Schema::table('reportes', function (Blueprint $table) {
            $table->renameColumn('id_areas', 'area_id');
        });

        Schema::table('infraestructuras', function (Blueprint $table) {
            $table->renameColumn('id_areas', 'area_id');
        });

        Schema::table('areas', function (Blueprint $table) {
            $table->renameColumn('id_areas', 'id');
        });
    }
};