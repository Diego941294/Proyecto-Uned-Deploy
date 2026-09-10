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
        Schema::create('check_items', function (Blueprint $table) {
    $table->id();

    $table->foreignId('area_id')
        ->constrained()
        ->onDelete('cascade');

    $table->string('seccion');

    $table->string('nombre');

    $table->integer('orden')->default(0);

    $table->boolean('activo')->default(true);

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_items');
    }
};
