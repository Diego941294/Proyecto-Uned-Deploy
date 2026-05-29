<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reporte_detalles', function (Blueprint $table) {
            $table->enum('lunes', ['A', 'NC', 'NA', 'NFR'])->nullable()->after('check_item_id');
            $table->enum('martes', ['A', 'NC', 'NA', 'NFR'])->nullable()->after('lunes');
            $table->enum('miercoles', ['A', 'NC', 'NA', 'NFR'])->nullable()->after('martes');
            $table->enum('jueves', ['A', 'NC', 'NA', 'NFR'])->nullable()->after('miercoles');
            $table->enum('viernes', ['A', 'NC', 'NA', 'NFR'])->nullable()->after('jueves');
            $table->enum('sabado', ['A', 'NC', 'NA', 'NFR'])->nullable()->after('viernes');
        });
    }

    public function down(): void
    {
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
};