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
        | USERS
        |--------------------------------------------------------------------------
        */

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn(
                'id',
                'id_users'
            );
        });

        /*
        |--------------------------------------------------------------------------
        | REPORTES
        |--------------------------------------------------------------------------
        */

        Schema::table('reportes', function (Blueprint $table) {

            $table->renameColumn(
                'user_id',
                'id_users'
            );

            $table->renameColumn(
                'aprobado_por',
                'id_usuario_aprobador'
            );
        });
    }

    public function down(): void
    {
        Schema::table('reportes', function (Blueprint $table) {

            $table->renameColumn(
                'id_users',
                'user_id'
            );

            $table->renameColumn(
                'id_usuario_aprobador',
                'aprobado_por'
            );
        });

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn(
                'id_users',
                'id'
            );
        });
    }
};