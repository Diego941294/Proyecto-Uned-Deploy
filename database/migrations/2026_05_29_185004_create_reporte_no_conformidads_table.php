<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reporte_no_conformidades', function (Blueprint $table) {
            $table->id();

            $table->foreignId('reporte_id')
                ->constrained('reportes')
                ->onDelete('cascade');

            $table->date('fecha')->nullable();
            $table->string('referencia')->nullable();
            $table->text('causa_raiz')->nullable();
            $table->time('hora_causa')->nullable();
            $table->text('accion_correctiva')->nullable();
            $table->time('hora_accion')->nullable();
            $table->text('verificacion')->nullable();
            $table->string('coordinador_area')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reporte_no_conformidades');
    }
};