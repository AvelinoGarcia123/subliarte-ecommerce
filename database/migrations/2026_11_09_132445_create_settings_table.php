<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            // Datos de Pago Móvil
            $table->string('pm_banco')->nullable();
            $table->string('pm_telefono')->nullable();
            $table->string('pm_cedula_rif')->nullable();
            
            // Redes Sociales
            $table->string('whatsapp')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            
            // Promociones
            $table->text('promociones')->nullable(); // Un mensaje global para la tienda
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};