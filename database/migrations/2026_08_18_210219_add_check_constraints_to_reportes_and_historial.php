<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | REPORTES
        |--------------------------------------------------------------------------
        | Restringimos los estados válidos del reporte.
        */

        Schema::table('reportes', function (Blueprint $table) {

            $table->enum(
                'estado',
                [
                    'borrador',
                    'enviado',
                    'aprobado',
                    'rechazado',
                ]
            )
            ->default('borrador')
            ->change();
        });


        /*
        |--------------------------------------------------------------------------
        | HISTORIAL DE ESTADOS
        |--------------------------------------------------------------------------
        | estado_anterior puede ser NULL porque un registro inicial
        | puede no tener un estado previo.
        */

        Schema::table('reporte_historial_estados', function (Blueprint $table) {

            $table->enum(
                'estado_anterior',
                [
                    'borrador',
                    'enviado',
                    'aprobado',
                    'rechazado',
                ]
            )
            ->nullable()
            ->change();


            $table->enum(
                'estado_nuevo',
                [
                    'borrador',
                    'enviado',
                    'aprobado',
                    'rechazado',
                ]
            )
            ->change();
        });
    }


    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | REVERSIÓN
        |--------------------------------------------------------------------------
        | Volvemos a varchar para eliminar los CHECK.
        */

        Schema::table('reporte_historial_estados', function (Blueprint $table) {

            $table->string('estado_anterior')
                ->nullable()
                ->change();

            $table->string('estado_nuevo')
                ->change();
        });


        Schema::table('reportes', function (Blueprint $table) {

            $table->string('estado')
                ->default('borrador')
                ->change();
        });
    }
};