<div class="max-w-4xl mx-auto px-4 py-16 min-h-screen">
    <h1 class="text-4xl font-extrabold text-white mb-8">Tu Carrito de Compras</h1>

    @if(session()->has('message'))
        <div class="bg-green-500/20 border border-green-500 text-green-400 px-4 py-3 rounded-lg mb-6">
            {{ session('message') }}
        </div>
    @endif

    @if(count($cart) > 0)
        <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden backdrop-blur-md">
            <div class="p-6">
                @foreach($cart as $id => $details)
                    <div class="flex items-center justify-between border-b border-white/10 py-4 last:border-0">
                        <div class="flex items-center gap-4">
                            @if($details['image'])
                                <img src="{{ asset('storage/' . $details['image']) }}" class="w-16 h-16 rounded-lg object-cover">
                            @endif
                            <div>
                                <h3 class="text-white font-bold text-lg">{{ $details['name'] }}</h3>
                                <p class="text-gray-400 text-sm">${{ number_format($details['price'], 2) }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <!-- Controles de cantidad -->
                            <div class="flex items-center bg-brand-dark rounded-lg border border-white/10">
                                <button wire:click="decrement({{ $id }})" class="px-3 py-1 text-white hover:text-brand-cyan">-</button>
                                <span class="px-3 py-1 text-white font-semibold">{{ $details['quantity'] }}</span>
                                <button wire:click="increment({{ $id }})" class="px-3 py-1 text-white hover:text-brand-cyan">+</button>
                            </div>
                            
                            <!-- Subtotal -->
                            <span class="text-white font-bold w-24 text-right">
                                ${{ number_format($details['price'] * $details['quantity'], 2) }}
                            </span>

                            <!-- Botón eliminar -->
                            <button wire:click="remove({{ $id }})" class="text-red-400 hover:text-red-300 ml-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Resumen Total -->
            <div class="bg-white/5 p-6 border-t border-white/10 flex justify-between items-center">
                <div>
                    <p class="text-gray-400 text-sm">Total a pagar:</p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-extrabold text-white">${{ number_format($totalUsd, 2) }}</span>
                        @if($tasaBcv > 0)
                            <span class="text-brand-cyan font-semibold text-lg">(Bs. {{ number_format($totalUsd * $tasaBcv, 2) }})</span>
                        @endif
                    </div>
                </div>
                <a href="{{ route('checkout') }}" class="bg-gradient-to-r from-brand-purple to-brand-cyan hover:from-purple-500 hover:to-cyan-400 text-white font-bold py-3 px-8 rounded-xl transition duration-300 shadow-lg shadow-brand-cyan/30">
                    Proceder al Pago
                </a>
            </div>
        </div>
    @else
        <div class="text-center py-20 bg-white/5 rounded-2xl border border-white/10">
            <svg class="w-20 h-20 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            <h2 class="text-2xl font-bold text-white mb-2">Tu carrito está vacío</h2>
            <p class="text-gray-400 mb-6">Parece que aún no has añadido ningún producto.</p>
            <a href="{{ route('home') }}" class="bg-white/10 hover:bg-white/20 text-white px-6 py-2 rounded-lg transition">Volver al Catálogo</a>
        </div>
    @endif
</div>