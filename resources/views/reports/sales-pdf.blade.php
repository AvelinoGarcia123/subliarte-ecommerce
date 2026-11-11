<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas - Subli-Arte</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #4f46e5; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #4f46e5; }
        .header p { margin: 5px 0; color: #666; }
        .info { margin-bottom: 20px; }
        .info strong { color: #4f46e5; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f3f4f6; color: #4f46e5; }
        .total-box { text-align: right; font-size: 14px; font-weight: bold; color: #4f46e5; }
        .footer { text-align: center; font-size: 10px; color: #999; margin-top: 40px; position: fixed; bottom: 0; width: 100%; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Subli-Arte F.P.</h1>
        <p>Reporte de Ventas Oficial</p>
    </div>

    <div class="info">
        <p><strong>Rango del Reporte:</strong> Desde {{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }} hasta {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}</p>
        <p><strong>Fecha de Emisión:</strong> {{ now()->format('d/m/Y h:i A') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nro.</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                <td>{{ $order->user->name ?? 'Cliente' }}</td>
                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                <td>{{ strtoupper($order->status) }}</td>
                <td>${{ number_format($order->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-box">
        Total Recaudado en el Periodo: ${{ number_format($totalVentas, 2) }}
    </div>

    <div class="footer">
        Generado automáticamente por el Sistema E-Commerce de Subli-Arte F.P. - Punta de Mata, Monagas.
    </div>

</body>
</html>