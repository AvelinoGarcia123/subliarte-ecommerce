<div class="max-w-4xl mx-auto px-4 py-16 min-h-screen">
    <h1 class="text-4xl font-extrabold text-white mb-8">Finalizar Compra</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- Columna Izquierda: Datos y Archivos (2/3) -->
        <div class="md:col-span-2 space-y-6">
            
            <!-- Datos del Cliente -->
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6 backdrop-blur-md">
                <h2 class="text-xl font-bold text-white mb-4">Tus Datos</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Nombre Completo (Registrado)</label>
                        <input type="text" value="{{ auth()->user()->name }}" disabled class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-gray-500 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Teléfono de Contacto</label>
                        <input type="text" wire:model="customer_phone" placeholder="Ej: 04141234567" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-3 text-white focus:border-brand-cyan focus:outline-none">
                        @error('customer_phone') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Dirección de Entrega</label>
                        <input type="text" wire:model="customer_address" placeholder="Ej: Calle 5 de Julio, Casa 123" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-3 text-white focus:border-brand-cyan focus:outline-none">
                        @error('customer_address') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Personalización y Pago -->
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6 backdrop-blur-md">
                <h2 class="text-xl font-bold text-white mb-4">Personalización y Pago</h2>
                
                <div class="space-y-6">
                    <!-- Subir Diseño -->
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Sube el diseño que quieres sublimar</label>
                        <input type="file" wire:model="customization_file" class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-brand-purple/20 file:text-brand-purple hover:file:bg-brand-purple/30 transition">
                        <p class="text-xs text-gray-500 mt-1">Formatos: JPG, PNG. (Máx. 5MB)</p>
                        @error('customization_file') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        
                        <!-- Barra de progreso de subida -->
                        <div wire:loading wire:target="customization_file" class="text-brand-cyan text-xs mt-2">Subiendo diseño...</div>
                    </div>

                    <!-- Notas -->
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Instrucciones para el diseño (Opcional)</label>
                        <textarea wire:model="customization_notes" rows="2" placeholder="Ej: Poner el nombre 'María' en letras doradas" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-3 text-white focus:border-brand-cyan focus:outline-none"></textarea>
                    </div>

                    <!-- Subir Comprobante -->
                    <div class="border-t border-white/10 pt-4">
                        <label class="block text-sm text-gray-400 mb-1">Sube tu comprobante de Pago Móvil / Transferencia</label>
                        <input type="file" wire:model="payment_receipt" class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-brand-cyan/20 file:text-brand-cyan hover:file:bg-brand-cyan/30 transition">
                        @error('payment_receipt') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        
                        <div wire:loading wire:target="payment_receipt" class="text-brand-cyan text-xs mt-2">Subiendo comprobante...</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Columna Derecha: Resumen de Pago (1/3) -->
        <div class="md:col-span-1">
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6 sticky top-24 backdrop-blur-md">
                <h2 class="text-lg font-bold text-white mb-4 border-b border-white/10 pb-4">Resumen a Pagar</h2>
                
                <div class="space-y-3 mb-6">
                    @foreach($cart as $item)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">{{ $item['quantity'] }}x {{ $item['name'] }}</span>
                            <span class="text-white">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-white/10 pt-4 mb-6">
                    <div class="flex justify-between items-baseline mb-1">
                        <span class="text-gray-400">Total USD:</span>
                        <span class="text-2xl font-bold text-white">${{ number_format($totalUsd, 2) }}</span>
                    </div>
                    @if($tasaBcv > 0)
                        <div class="flex justify-between items-baseline text-brand-cyan">
                            <span class="text-sm">Total Bs:</span>
                            <span class="font-bold">Bs. {{ number_format($totalUsd * $tasaBcv, 2) }}</span>
                        </div>
                    @endif
                </div>

                <!-- Datos de Pago Móvil (Desde la Configuración del Admin) -->
                <!-- Datos de Pago (Múltiples Cuentas) -->
                @if($setting && $setting->bankAccounts->where('is_active', true)->count() > 0)
                    <div class="bg-brand-dark rounded-xl p-4 border border-brand-cyan/30 mb-6 max-h-64 overflow-y-auto">
                        <h3 class="text-xs font-bold text-brand-cyan uppercase tracking-wider mb-3">Cuentas para Realizar el Pago</h3>
                        
                        <div class="space-y-4">
                            @foreach($setting->bankAccounts->where('is_active', true) as $account)
                                <div class="bg-white/5 p-3 rounded-lg border border-white/10">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-sm font-bold text-white">{{ $account->bank_name }}</span>
                                        <span class="text-[10px] bg-brand-purple/20 text-brand-purple px-2 py-0.5 rounded-full">{{ $account->account_type }}</span>
                                    </div>
                                    
                                    @if($account->account_type === 'Pago Móvil')
                                        <div class="text-xs text-gray-300 space-y-0.5">
                                            <p><span class="text-gray-500">Teléfono:</span> {{ $account->phone }}</p>
                                            <p><span class="text-gray-500">C.I / RIF:</span> {{ $account->id_number }}</p>
                                        </div>
                                    @else
                                        <div class="text-xs text-gray-300">
                                            <p><span class="text-gray-500">Cuenta:</span> {{ $account->account_number }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <button wire:click="placeOrder" wire:loading.attr="disabled" class="w-full bg-gradient-to-r from-brand-purple to-brand-cyan hover:from-purple-500 hover:to-cyan-400 text-white font-bold py-3 px-4 rounded-xl transition duration-300 shadow-lg shadow-brand-cyan/30 flex justify-center items-center gap-2">
                    <span wire:loading.remove wire:target="placeOrder">Confirmar Pedido</span>
                    <span wire:loading wire:target="placeOrder">Procesando...</span>
                </button>
            </div>
        </div>
    </div>
</div>