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
                ->constrained('users')
                ->onDelete('restrict');

            $table->foreignId('area_id')
                ->constrained('areas')
                ->onDelete('restrict');

            $table->date('fecha');

            $table->integer('semana')
                ->nullable();

            $table->enum(
                'estado',
                [
                    'borrador',
                    'enviado',
                    'aprobado',
                    'rechazado'
                ]
            )->default('borrador');

            $table->text('observaciones')
                ->nullable();

            /*
             * aprobado_por y fecha_aprobacion
             * se agregan en una migración posterior.
             */

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