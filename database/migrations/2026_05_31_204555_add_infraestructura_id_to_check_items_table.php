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
    Schema::table('check_items', function (Blueprint $table) {
        $table->foreignId('infraestructura_id')
            ->nullable()
            ->after('area_id')
            ->constrained('infraestructuras')
            ->nullOnDelete();
    });
}

public function down(): void
{
    Schema::table('check_items', function (Blueprint $table) {
        $table->dropForeign(['infraestructura_id']);
        $table->dropColumn('infraestructura_id');
    });
}
};
