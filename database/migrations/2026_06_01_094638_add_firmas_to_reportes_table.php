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
        Schema::table('reportes', function (Blueprint $table) {
            $table->string('inspector_calidad')->nullable()->after('observaciones');
            $table->string('firma_inspector')->nullable()->after('inspector_calidad');

            $table->string('verificador_calidad')->nullable()->after('firma_inspector');
            $table->string('firma_verificador')->nullable()->after('verificador_calidad');
        });
    }

    public function down(): void
    {
        Schema::table('reportes', function (Blueprint $table) {
            $table->dropColumn([
                'inspector_calidad',
                'firma_inspector',
                'verificador_calidad',
                'firma_verificador',
            ]);
        });
    }
};
