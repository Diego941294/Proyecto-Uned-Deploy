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
        Schema::create('reportes', function (Blueprint $table) {
    $table->id();

    $table->foreignId('user_id')
        ->constrained()
        ->onDelete('restrict');

    $table->foreignId('area_id')
        ->constrained()
        ->onDelete('restrict');

    $table->date('fecha');
    $table->integer('semana')->nullable();

    $table->enum('estado', ['borrador', 'enviado', 'aprobado', 'rechazado'])
        ->default('borrador');

    $table->text('observaciones')->nullable();

    $table->foreignId('aprobado_por')
        ->nullable()
        ->constrained('users')
        ->nullOnDelete();

    $table->timestamp('fecha_aprobacion')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};
