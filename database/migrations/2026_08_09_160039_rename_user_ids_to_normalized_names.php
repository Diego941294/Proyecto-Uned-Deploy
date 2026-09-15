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

        if (
            Schema::hasColumn('users', 'id') &&
            !Schema::hasColumn('users', 'id_users')
        ) {
            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn(
                    'id',
                    'id_users'
                );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | REPORTES - USUARIO CREADOR
        |--------------------------------------------------------------------------
        */

        if (
            Schema::hasColumn('reportes', 'user_id') &&
            !Schema::hasColumn('reportes', 'id_users')
        ) {
            Schema::table('reportes', function (Blueprint $table) {
                $table->renameColumn(
                    'user_id',
                    'id_users'
                );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | REPORTES - USUARIO APROBADOR
        |--------------------------------------------------------------------------
        */

        if (
            Schema::hasColumn('reportes', 'aprobado_por') &&
            !Schema::hasColumn('reportes', 'id_usuario_aprobador')
        ) {
            Schema::table('reportes', function (Blueprint $table) {
                $table->renameColumn(
                    'aprobado_por',
                    'id_usuario_aprobador'
                );
            });
        }
    }

    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | REPORTES - USUARIO APROBADOR
        |--------------------------------------------------------------------------
        */

        if (
            Schema::hasColumn('reportes', 'id_usuario_aprobador') &&
            !Schema::hasColumn('reportes', 'aprobado_por')
        ) {
            Schema::table('reportes', function (Blueprint $table) {
                $table->renameColumn(
                    'id_usuario_aprobador',
                    'aprobado_por'
                );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | REPORTES - USUARIO CREADOR
        |--------------------------------------------------------------------------
        */

        if (
            Schema::hasColumn('reportes', 'id_users') &&
            !Schema::hasColumn('reportes', 'user_id')
        ) {
            Schema::table('reportes', function (Blueprint $table) {
                $table->renameColumn(
                    'id_users',
                    'user_id'
                );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | USERS
        |--------------------------------------------------------------------------
        */

        if (
            Schema::hasColumn('users', 'id_users') &&
            !Schema::hasColumn('users', 'id')
        ) {
            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn(
                    'id_users',
                    'id'
                );
            });
        }
    }
};