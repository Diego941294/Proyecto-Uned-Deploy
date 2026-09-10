<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('check_items', function (Blueprint $table) {
            $table->dropColumn('seccion');
        });
    }

    public function down(): void
    {
        Schema::table('check_items', function (Blueprint $table) {
            $table->string('seccion')->nullable();
        });
    }
};