<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
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

    public function down(): void
    {
        Schema::table('reportes', function (Blueprint $table) {
            $table->string('inspector_calidad')->nullable();
            $table->text('firma_inspector')->nullable();
            $table->string('verificador_calidad')->nullable();
            $table->text('firma_verificador')->nullable();
        });
    }
};