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
Schema::create('reporte_detalles', function (Blueprint $table) {
    $table->id();

    $table->foreignId('reporte_id')
        ->constrained('reportes')
        ->onDelete('cascade');

    $table->foreignId('check_item_id')
        ->constrained('check_items')
        ->onDelete('restrict');

    $table->enum('estado', ['A', 'NC', 'NA', 'NFR'])
        ->default('NA');

    $table->text('observacion')->nullable();

    $table->timestamps();

    $table->unique(['reporte_id', 'check_item_id']);
});    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reporte_detalles');
    }
};
