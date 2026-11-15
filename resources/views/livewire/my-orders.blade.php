<div class="max-w-7xl mx-auto px-4 py-16 min-h-screen">
    <div class="flex justify-between items-end mb-8 border-b border-white/10 pb-4">
        <div>
            <h1 class="text-4xl font-extrabold text-white mb-2">Mis Pedidos</h1>
            <p class="text-gray-400">Revisa el estado de tus compras y diseños.</p>
        </div>
        @if($tasaBcv > 0)
            <div class="text-sm text-gray-400 bg-white/5 border border-white/10 px-4 py-2 rounded-lg">
                Tasa BCV: <span class="font-bold text-brand-cyan">{{ number_format($tasaBcv, 2) }} Bs/$</span>
            </div>
        @endif
    </div>

    <!-- Mensajes de Éxito / Alerta -->
    @if(session()->has('success'))
        <div class="bg-green-500/20 border border-green-500 text-green-400 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif
    
    @if(session()->has('message'))
        <div class="bg-brand-cyan/20 border border-brand-cyan text-brand-cyan px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('message') }}
        </div>
    @endif

    @if($orders->count() > 0)
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden backdrop-blur-md">
                    <!-- Cabecera del Pedido -->
                    <div class="bg-white/5 px-6 py-4 border-b border-white/10 flex flex-wrap justify-between items-center gap-4">
                        <div>
                            <p class="text-sm text-gray-400">Pedido <span class="text-white font-bold">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span></p>
                            <p class="text-xs text-gray-500">{{ $order->created_at->format('d/m/Y h:i A') }}</p>
                        </div>
                        
                        <!-- Badge del Estado -->
                        <div>
                            @php
                                $statusColors = [
                                    'pendiente' => 'bg-yellow-500/20 text-yellow-400 border-yellow-500/30',
                                    'pagado' => 'bg-green-500/20 text-green-400 border-green-500/30',
                                    'en_produccion' => 'bg-blue-500/20 text-blue-400 border-blue-500/30',
                                    'entregado' => 'bg-gray-500/20 text-gray-400 border-gray-500/30',
                                    'cancelado' => 'bg-red-500/20 text-red-400 border-red-500/30', // ✅ Nuevo estado
                                ];
                                $statusNames = [
                                    'pendiente' => '⏳ Pendiente de Pago',
                                    'pagado' => '✅ Pagado',
                                    'en_produccion' => '🎨 En Producción',
                                    'entregado' => '📦 Entregado',
                                    'cancelado' => '❌ Cancelado', // ✅ Nuevo estado
                                ];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $statusColors[$order->status] ?? 'bg-gray-500/20 text-gray-400' }}">
                                {{ $statusNames[$order->status] ?? strtoupper($order->status) }}
                            </span>
                        </div>
                    </div>

                    <!-- Detalles de los Productos -->
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($order->items as $item)
                                <div class="flex items-center gap-4">
                                    @if($item->product->image_path)
                                        <img src="{{ asset('storage/' . $item->product->image_path) }}" class="w-16 h-16 rounded-lg object-cover border border-white/10">
                                    @else
                                        <div class="w-16 h-16 rounded-lg bg-white/5 flex items-center justify-center text-gray-500 text-xs">Sin foto</div>
                                    @endif
                                    <div class="flex-1">
                                        <h3 class="text-white font-bold">{{ $item->product->name }}</h3>
                                        <p class="text-gray-400 text-sm">Cantidad: {{ $item->quantity }}</p>
                                        @if($item->customization_notes)
                                            <p class="text-xs text-brand-cyan mt-1">Nota: {{ $item->customization_notes }}</p>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <p class="text-white font-bold">${{ number_format($item->price, 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Total y Botones de Acción -->
                        <div class="mt-6 pt-4 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-4">
                            
                            <!-- Total -->
                            <div class="flex items-baseline gap-4 w-full md:w-auto">
                                <span class="text-gray-400 text-sm">Total Pagado:</span>
                                <div class="text-left">
                                    <p class="text-xl font-extrabold text-white">${{ number_format($order->total, 2) }}</p>
                                    @if($tasaBcv > 0)
                                        <p class="text-sm text-brand-cyan font-semibold">Bs. {{ number_format($order->total * $tasaBcv, 2) }}</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="flex gap-3 w-full md:w-auto justify-end">
                                <!-- Botón Descargar Factura -->
                                <a href="{{ route('download.invoice', $order->id) }}" target="_blank" class="bg-white/5 hover:bg-white/10 text-white px-4 py-2 rounded-lg text-sm font-bold transition border border-white/10 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Factura
                                </a>

                                <!-- Botón Cancelar Pedido (Solo si está pendiente o pagado) -->
                                @if(in_array($order->status, ['pendiente', 'pagado']))
                                    <button wire:click="cancelOrder({{ $order->id }})" wire:confirm="¿Estás seguro de que deseas cancelar este pedido?" class="bg-red-500/10 text-red-400 hover:bg-red-500/20 px-4 py-2 rounded-lg text-sm font-bold transition border border-red-500/30 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        Cancelar
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Estado Vacío -->
        <div class="text-center py-20 bg-white/5 rounded-2xl border border-white/10">
            <svg class="w-20 h-20 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            <h2 class="text-2xl font-bold text-white mb-2">Aún no tienes pedidos</h2>
            <p class="text-gray-400 mb-6">¡Explora nuestro catálogo y personaliza tu primer producto!</p>
            <a href="{{ route('home') }}" class="bg-gradient-to-r from-brand-purple to-brand-cyan hover:from-purple-500 hover:to-cyan-400 text-white font-bold py-2 px-6 rounded-lg transition">Ir al Catálogo</a>
        </div>
    @endif
</div>