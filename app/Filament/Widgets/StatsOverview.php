<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1; 

    protected function getStats(): array
    {
        $ventasHoy = Order::whereDate('created_at', today())->sum('total');
        $pedidosHoy = Order::whereDate('created_at', today())->count();
        $totalClientes = User::where('role', 'cliente')->count();
        $totalProductos = Product::count();

        return [
            Stat::make('Ventas de Hoy', '$ ' . number_format($ventasHoy, 2))
                ->description('Ingresos generados hoy')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
                
            Stat::make('Pedidos de Hoy', $pedidosHoy)
                ->description('Nuevas órdenes recibidas')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('warning'),
                
            Stat::make('Clientes Registrados', $totalClientes)
                ->description('Total en la base de datos')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Productos en Catálogo', $totalProductos)
                ->description('Tazas, camisas, etc.')
                ->descriptionIcon('heroicon-m-squares-2x2')
                ->color('info'),
        ];
    }
}