<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Order;
use Carbon\Carbon;

class SalesChart extends ChartWidget
{
    protected static ?string $heading = 'Ingresos de los Últimos 7 Días';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->isoFormat('ddd D'); 
            
            $total = Order::whereDate('created_at', $date)->sum('total');
            $data[] = $total;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Ventas ($)',
                    'data' => $data,
                    'backgroundColor' => 'rgba(6, 182, 212, 0.1)',
                    'borderColor' => '#8b5cf6',
                    'borderWidth' => 3,
                    'fill' => true,
                    'tension' => 0.4,
                    'pointBackgroundColor' => '#06b6d4',
                    'pointBorderColor' => '#fff',
                    'pointRadius' => 4,
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