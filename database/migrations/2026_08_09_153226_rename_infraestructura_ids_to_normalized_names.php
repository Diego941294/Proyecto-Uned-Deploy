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
        /*
        |--------------------------------------------------------------------------
        | INFRAESTRUCTURAS
        |--------------------------------------------------------------------------
        | PK:
        | id -> id_infraestructuras
        */

        Schema::table('infraestructuras', function (Blueprint $table) {
            $table->renameColumn('id', 'id_infraestructuras');
        });


        /*
        |--------------------------------------------------------------------------
        | CHECK ITEMS
        |--------------------------------------------------------------------------
        | FK:
        | infraestructura_id -> id_infraestructuras
        */

        Schema::table('check_items', function (Blueprint $table) {
            $table->renameColumn(
                'infraestructura_id',
                'id_infraestructuras'
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
        | CHECK ITEMS
        |--------------------------------------------------------------------------
        */

        Schema::table('check_items', function (Blueprint $table) {
            $table->renameColumn(
                'id_infraestructuras',
                'infraestructura_id'
            );
        });


        /*
        |--------------------------------------------------------------------------
        | INFRAESTRUCTURAS
        |--------------------------------------------------------------------------
        */

        Schema::table('infraestructuras', function (Blueprint $table) {
            $table->renameColumn(
                'id_infraestructuras',
                'id'
            );
        });
    }
};