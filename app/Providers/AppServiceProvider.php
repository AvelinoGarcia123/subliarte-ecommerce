<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Order;
use App\Observers\OrderObserver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // ❌ COMENTADO PARA EVITAR CONFLICTOS
        // Order::observe(OrderObserver::class);
    }
}