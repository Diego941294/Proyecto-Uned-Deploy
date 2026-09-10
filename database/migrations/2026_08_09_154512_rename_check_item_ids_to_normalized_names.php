<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('check_items', function (Blueprint $table) {
            $table->renameColumn('id', 'id_check_items');
        });

        Schema::table('reporte_detalles', function (Blueprint $table) {
            $table->renameColumn(
                'check_item_id',
                'id_check_items'
            );
        });
    }

    public function down(): void
    {
        Schema::table('reporte_detalles', function (Blueprint $table) {
            $table->renameColumn(
                'id_check_items',
                'check_item_id'
            );
        });

        Schema::table('check_items', function (Blueprint $table) {
            $table->renameColumn(
                'id_check_items',
                'id'
            );
        });
    }
};