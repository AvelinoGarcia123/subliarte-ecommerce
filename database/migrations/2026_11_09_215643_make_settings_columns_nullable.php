<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Hacemos que las columnas antiguas sean opcionales
            $table->string('pm_banco')->nullable()->change();
            $table->string('pm_telefono')->nullable()->change();
            $table->string('pm_cedula_rif')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Revertir (opcional)
            $table->string('pm_banco')->nullable(false)->change();
            $table->string('pm_telefono')->nullable(false)->change();
            $table->string('pm_cedula_rif')->nullable(false)->change();
        });
    }
};