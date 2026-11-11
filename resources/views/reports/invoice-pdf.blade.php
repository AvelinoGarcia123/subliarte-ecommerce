<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura Subli-Arte #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        /* Configuración general para DomPDF */
        @page { margin: 40px 50px; }
        body { 
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; 
            font-size: 12px; 
            color: #333; 
            line-height: 1.5;
        }

        /* Colores de la marca */
        .text-indigo { color: #4f46e5; }
        .text-gray { color: #6b7280; }

        /* Encabezado */
        .header-table { width: 100%; margin-bottom: 30px; border-bottom: 2px solid #4f46e5; padding-bottom: 15px; }
        .company-logo { 
            font-size: 28px; 
            font-weight: 900; 
            color: #4f46e5; 
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        .company-info p { margin: 3px 0; font-size: 11px; color: #555; }
        
        .invoice-title { text-align: right; }
        .invoice-title h1 { margin: 0; font-size: 26px; color: #1f2937; text-transform: uppercase; letter-spacing: 2px; }
        .invoice-title p { margin: 5px 0; font-size: 12px; }
        .invoice-number { font-size: 16px; font-weight: bold; color: #4f46e5; }

        /* Información del Cliente */
        .info-table { width: 100%; margin-bottom: 30px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; }
        .info-table td { padding: 15px; vertical-align: top; }
        .info-box h3 { margin: 0 0 10px 0; font-size: 12px; color: #4f46e5; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; padding-bottom: 5px; }
        .info-box p { margin: 3px 0; font-size: 11px; }

        /* Tabla de Productos */
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .items-table th { 
            background-color: #4f46e5; 
            color: white; 
            padding: 10px; 
            text-align: left; 
            font-size: 11px; 
            text-transform: uppercase;
        }
        .items-table td { padding: 10px; border-bottom: 1px solid #e5e7eb; font-size: 12px; }
        .items-table tr:nth-child(even) { background-color: #f9fafb; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }

        /* Totales y QR */
        .footer-table { width: 100%; margin-top: 20px; }
        .qr-box { width: 120px; text-align: center; }
        .qr-box p { font-size: 9px; color: #888; margin-top: 5px; }

        .totals-box { text-align: right; }
        .totals-table { margin-left: auto; width: 250px; }
        .totals-table td { padding: 5px 10px; font-size: 12px; }
        .total-row td { border-top: 2px solid #4f46e5; font-size: 16px; font-weight: bold; color: #4f46e5; padding-top: 10px; }
        .total-bs-row td { font-size: 13px; color: #555; font-weight: bold; }

        /* Pie de Página */
        .footer-text { text-align: center; font-size: 10px; color: #9ca3af; margin-top: 50px; border-top: 1px solid #e5e7eb; padding-top: 15px; }
    </style>
</head>
<body>

    <!-- ENCABEZADO -->
    <table class="header-table">
        <tr>
            <td width="50%">
                <div class="company-logo">Subli-Arte F.P.</div>
                <div class="company-info">
                    <p><strong>RIF:</strong> J-12345678-9 (Coloca el RIF real)</p>
                    <p>Casco Central, Punta de Mata, Monagas.</p>
                    <p>Teléfono: 0414-1234567</p>
                    <p>Instagram: @subliarte.fp</p>
                </div>
            </td>
            <td width="50%" class="invoice-title">
                <h1>FACTURA</h1>
                <p class="invoice-number">N° {{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                <p><strong>Fecha:</strong> {{ $order->created_at->format('d/m/Y h:i A') }}</p>
                <p><strong>Estado:</strong> <span style="color: #10b981; font-weight: bold;">PAGADO</span></p>
            </td>
        </tr>
    </table>

    <!-- INFORMACIÓN DEL CLIENTE -->
    <table class="info-table">
        <tr>
            <td width="50%" class="info-box">
                <h3>Datos del Cliente</h3>
                <p><strong>Nombre:</strong> {{ $order->customer_name ?? $order->user->name ?? 'Consumidor Final' }}</p>
                @if($order->customer_id_number)
                    <p><strong>Cédula/RIF:</strong> {{ strtoupper($order->customer_id_number) }}</p>
                @endif
                @if($order->customer_phone)
                    <p><strong>Teléfono:</strong> {{ $order->customer_phone }}</p>
                @endif
                @if($order->customer_address)
                    <p><strong>Dirección:</strong> {{ $order->customer_address }}</p>
                @endif
            </td>
            <td width="50%" class="info-box">
                <h3>Detalles de Venta</h3>
                <p><strong>Canal:</strong> {{ strtoupper($order->sale_type) }}</p>
                <p><strong>Método de Pago:</strong> Pago Móvil / Transferencia</p>
                <p><strong>Atendido por:</strong> Sistema E-Commerce</p>
            </td>
        </tr>
    </table>

    <!-- TABLA DE PRODUCTOS -->
    <table class="items-table">
        <thead>
            <tr>
                <th width="50%">Descripción del Producto</th>
                <th width="15%" class="text-center">Cant.</th>
                <th width="15%" class="text-right">Precio Unit.</th>
                <th width="20%" class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>
                    <strong>{{ $item->product->name ?? 'Producto' }}</strong>
                    @if($item->customization_notes)
                        <br><span style="font-size: 10px; color: #666;"><em>Nota: {{ $item->customization_notes }}</em></span>
                    @endif
                </td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">${{ number_format($item->price, 2) }}</td>
                <td class="text-right">${{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- TOTALES Y QR -->
    <table class="footer-table">
        <tr>
            <!-- Código QR -->
            <td width="50%" style="vertical-align: bottom;">
                <div class="qr-box">
                    <!-- QR generado por API externa para DomPDF -->
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=Factura%20SubliArte%20Nro:%20{{ $order->id }}%20Total:%20%24{{ $order->total }}" alt="QR Factura">
                    <p>Escanear para verificar</p>
                </div>
            </td>
            
            <!-- Cuadro de Totales -->
            <td width="50%" class="totals-box">
                <table class="totals-table">
                    <tr>
                        <td>Subtotal USD:</td>
                        <td class="text-right">${{ number_format($order->total, 2) }}</td>
                    </tr>
                    @if($rate > 0)
                    <tr class="total-bs-row">
                        <td>Tasa BCV:</td>
                        <td class="text-right">{{ number_format($rate, 2) }} Bs/$</td>
                    </tr>
                    @endif
                    <tr class="total-row">
                        <td>TOTAL USD:</td>
                        <td class="text-right">${{ number_format($order->total, 2) }}</td>
                    </tr>
                    @if($rate > 0)
                    <tr class="total-bs-row">
                        <td>TOTAL BOLÍVARES:</td>
                        <td class="text-right">Bs. {{ number_format($order->total * $rate, 2) }}</td>
                    </tr>
                    @endif
                </table>
            </td>
        </tr>
    </table>

    <!-- PIE DE PÁGINA -->
    <div class="footer-text">
        <p>¡Gracias por su compra! Subli-Arte transforma tus ideas en arte.</p>
        <p>Este documento es una representación impresa de una factura electrónica generada por el sistema Subli-Arte.</p>
    </div>

</body>
</html>