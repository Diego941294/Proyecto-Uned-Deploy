<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('infraestructuras', function (Blueprint $table) {

            $table->dropForeign(['id_areas']);

            $table->foreign('id_areas')
                ->references('id_areas')
                ->on('areas')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('infraestructuras', function (Blueprint $table) {

            $table->dropForeign(['id_areas']);

            $table->foreign('id_areas')
                ->references('id_areas')
                ->on('areas')
                ->cascadeOnDelete();
        });
    }
};