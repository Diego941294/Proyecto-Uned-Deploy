<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reportes', function (Blueprint $table) {

            $table->foreignId('aprobado_por')
                ->nullable()
                ->after('estado')
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('fecha_aprobacion')
                ->nullable()
                ->after('aprobado_por');

        });
    }

    public function down(): void
    {
        Schema::table('reportes', function (Blueprint $table) {

            $table->dropForeign(['aprobado_por']);

            $table->dropColumn([
                'aprobado_por',
                'fecha_aprobacion'
            ]);

        });
    }
};