<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ExchangeRate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function download(Order $order)
    {
        // Seguridad: que el cliente solo vea sus facturas
        if ($order->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $rate = ExchangeRate::getActiveRate()?->rate ?? 0;
        
        $pdf = Pdf::loadView('reports.invoice-pdf', [
            'order' => $order,
            'rate' => $rate
        ]);

        return $pdf->download('Factura_SubliArte_' . $order->id . '.pdf');
    }
}