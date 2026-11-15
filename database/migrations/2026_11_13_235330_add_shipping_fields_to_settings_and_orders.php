<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Campos para la configuración de la tienda
        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('enable_pickup')->default(true);
            $table->boolean('enable_delivery')->default(true);
            $table->decimal('delivery_cost', 10, 2)->default(0);
            $table->boolean('enable_national_shipping')->default(false);
            $table->string('national_agencies')->nullable(); // "MRW, Zoom, Tealca"
        });

        // Campos para los pedidos
        Schema::table('orders', function (Blueprint $table) {
            $table->string('shipping_method')->nullable(); // 'retiro', 'delivery', 'nacional'
            $table->string('shipping_details')->nullable(); // Dirección o Agencia
            $table->decimal('shipping_cost', 10, 2)->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['enable_pickup', 'enable_delivery', 'delivery_cost', 'enable_national_shipping', 'national_agencies']);
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['shipping_method', 'shipping_details', 'shipping_cost']);
        });
    }
};