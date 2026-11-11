<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Order;
use Carbon\Carbon;

class SalesChart extends ChartWidget
{
    protected static ?string $heading = 'Ventas de los Últimos 7 Días';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full'; 

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->format('d/m'); 
            
            $total = Order::whereDate('created_at', $date)->sum('total');
            $data[] = $total;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Ventas ($)',
                    'data' => $data,
                    'backgroundColor' => 'rgba(79, 70, 229, 0.2)',
                    'borderColor' => '#4f46e5',
                    'borderWidth' => 2,
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line'; 
    }
}