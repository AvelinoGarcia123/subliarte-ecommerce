<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('setting_id')->constrained()->onDelete('cascade');
            $table->string('bank_name'); // Ej: Banesco, Mercantil
            $table->string('account_type'); // Ej: Pago Móvil, Transferencia
            $table->string('phone')->nullable(); // Solo para Pago Móvil
            $table->string('id_number')->nullable(); // Cédula/RIF para Pago Móvil
            $table->string('account_number')->nullable(); // Número de cuenta para Transferencia
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};