<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    // ✅ Usamos la vista personalizada para el SweetAlert
    protected static string $view = 'filament.resources.order-resource.pages.list-orders';

    protected function getHeaderActions(): array
    {
        return [
            // ✅ NUEVO BOTÓN: Reporte para el sublimador
            Action::make('reporte_produccion')
                ->label('Reporte de Producción (Hoy)')
                ->icon('heroicon-o-printer')
                ->color('warning')
                ->action(function () {
                    // Traemos los pedidos de hoy que estén pagados o en producción
                    $orders = Order::whereDate('created_at', today())
                        ->whereIn('status', ['pagado', 'en_produccion'])
                        ->with(['items.product', 'user'])
                        ->get();

                    $pdf = Pdf::loadView('reports.production-pdf', [
                        'orders' => $orders,
                        'date' => now()->format('d/m/Y')
                    ]);

                    return response()->streamDownload(function () use ($pdf) {
                        echo $pdf->stream();
                    }, 'Reporte_Produccion_' . now()->format('Y-m-d') . '.pdf');
                }),
        ];
    }
}