
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reporte_snapshots', function (Blueprint $table) {
            $table->id('id_reporte_snapshots');

            $table->unsignedBigInteger('id_reportes')->unique();

            $table->foreign('id_reportes')
                ->references('id_reportes')
                ->on('reportes')
                ->restrictOnDelete();

            $table->string('estado_final', 20);

            // Copia completa del reporte y sus datos relacionados.
            $table->json('datos');

            $table->timestamp('fecha_snapshot');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reporte_snapshots');
    }
};