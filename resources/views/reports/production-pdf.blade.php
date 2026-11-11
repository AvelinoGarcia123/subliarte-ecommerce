<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Producción</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #4f46e5; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #4f46e5; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f3f4f6; color: #4f46e5; }
        .order-box { margin-bottom: 30px; border: 1px solid #ccc; padding: 10px; border-radius: 5px; page-break-inside: avoid; }
        .order-title { background: #e5e7eb; padding: 5px; font-weight: bold; margin-bottom: 10px; }
        .img-box { max-width: 150px; max-height: 150px; margin-top: 5px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Subli-Arte F.P.</h1>
        <p>Reporte de Producción - Pedidos para Sublimar</p>
        <p><strong>Fecha:</strong> {{ $date }}</p>
    </div>

    @if($orders->isEmpty())
        <p style="text-align: center; color: #666;">No hay pedidos pendientes por producir en este momento.</p>
    @else
        @foreach($orders as $order)
            <div class="order-box">
                <div class="order-title">
                    Pedido #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }} - Cliente: {{ $order->customer_name ?? $order->user->name ?? 'Mostrador' }}
                </div>
                
                <table>
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Notas / Instrucciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name ?? 'Producto' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>
                                {{ $item->customization_notes ?? 'Sin notas adicionales' }}
                                @if($item->customization_file_path)
                                    <br><br>
                                    <strong>Diseño adjunto:</strong><br>
                                    <!-- NOTA: Para que la imagen salga en el PDF, debe estar en la carpeta public -->
                                    <img src="{{ public_path('storage/' . $item->customization_file_path) }}" class="img-box">
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    @endif

</body>
</html>