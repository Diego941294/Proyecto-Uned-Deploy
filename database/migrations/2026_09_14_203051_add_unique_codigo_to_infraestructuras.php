<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('infraestructuras', function (Blueprint $table) {
            $table->unique(
                'codigo',
                'infraestructuras_codigo_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('infraestructuras', function (Blueprint $table) {
            $table->dropUnique(
                'infraestructuras_codigo_unique'
            );
        });
    }
};