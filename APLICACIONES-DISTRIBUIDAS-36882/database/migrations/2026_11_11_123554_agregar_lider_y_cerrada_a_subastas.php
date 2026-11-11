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
    Schema::table('subastas', function (Blueprint $table) {
        $table->string('lider')->nullable();
        $table->boolean('cerrada')->default(false);
    });
}

public function down(): void
{
    Schema::table('subastas', function (Blueprint $table) {
        $table->dropColumn(['lider', 'cerrada']);
    });
}
};
