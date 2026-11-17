<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 2; // Bajó un puesto para dejar pasar el banner
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $ventasHoy = Order::whereDate('created_at', today())->sum('total');
        $ventasAyer = Order::whereDate('created_at', today()->subDay())->sum('total');
        
        $pedidosHoy = Order::whereDate('created_at', today())->count();
        $pedidosAyer = Order::whereDate('created_at', today()->subDay())->count();
        
        $clientes = User::where('role', 'cliente')->count();
        $productos = Product::count();

        return [
            Stat::make('Ventas de Hoy', '$ ' . number_format($ventasHoy, 2))
                ->description($ventasHoy >= $ventasAyer ? 'Subió vs ayer' : 'Bajó vs ayer')
                ->descriptionIcon($ventasHoy >= $ventasAyer ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->descriptionColor($ventasHoy >= $ventasAyer ? 'success' : 'danger')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3])
                ->color('success'),
                
            Stat::make('Pedidos de Hoy', $pedidosHoy)
                ->description($pedidosHoy >= $pedidosAyer ? 'Más que ayer' : 'Menos que ayer')
                ->descriptionIcon($pedidosHoy >= $pedidosAyer ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->descriptionColor($pedidosHoy >= $pedidosAyer ? 'success' : 'danger')
                ->chart([3, 5, 2, 5, 7, 4, 6, 4])
                ->color('warning'),
                
            Stat::make('Clientes Registrados', $clientes)
                ->description('Total en la base de datos')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Productos en Catálogo', $productos)
                ->description('Tazas, camisas, etc.')
                ->descriptionIcon('heroicon-m-squares-2x2')
                ->color('info'),
        ];
    }
}