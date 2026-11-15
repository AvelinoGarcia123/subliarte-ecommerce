<div class="max-w-6xl mx-auto px-4 py-16 min-h-screen">
    <h1 class="text-4xl font-extrabold text-white mb-8">Finalizar Compra</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- Columna Izquierda: Formulario -->
        <div class="md:col-span-2 space-y-6">
            
            <!-- Datos del Cliente -->
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6 backdrop-blur-md">
                <h2 class="text-xl font-bold text-white mb-4">Tus Datos de Contacto</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Nombre Completo</label>
                        <input type="text" value="{{ auth()->user()->name }}" disabled class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-gray-500 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Teléfono</label>
                        <input type="text" wire:model="customer_phone" placeholder="Ej: 04141234567" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-3 text-white focus:border-brand-cyan focus:outline-none">
                        @error('customer_phone') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Métodos de Envío -->
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6 backdrop-blur-md">
                <h2 class="text-xl font-bold text-white mb-4">Método de Envío</h2>
                <div class="space-y-3">
                    
                    <!-- Retiro en Tienda -->
                    @if($settings->enable_pickup)
                        <label class="flex items-center p-4 border border-white/10 rounded-xl cursor-pointer hover:bg-white/5 transition {{ $shipping_method === 'retiro' ? 'border-brand-cyan bg-white/10' : '' }}">
                            <input type="radio" wire:model.live="shipping_method" value="retiro" class="text-brand-cyan focus:ring-brand-cyan bg-transparent border-white/20">
                            <div class="ml-3">
                                <span class="text-white font-bold block">Retiro en Tienda (Gratis)</span>
                                <span class="text-xs text-gray-400">Casco Central, Punta de Mata</span>
                            </div>
                        </label>
                    @endif

                    <!-- Delivery Local -->
                    @if($settings->enable_delivery)
                        <label class="flex items-center p-4 border border-white/10 rounded-xl cursor-pointer hover:bg-white/5 transition {{ $shipping_method === 'delivery' ? 'border-brand-cyan bg-white/10' : '' }}">
                            <input type="radio" wire:model.live="shipping_method" value="delivery" class="text-brand-cyan focus:ring-brand-cyan bg-transparent border-white/20">
                            <div class="ml-3">
                                <span class="text-white font-bold block">Delivery Local (+${{ number_format($settings->delivery_cost, 2) }})</span>
                                <span class="text-xs text-gray-400">Selecciona tu ubicación en el mapa</span>
                            </div>
                        </label>
                    @endif

                    <!-- Envío Nacional -->
                    @if($settings->enable_national_shipping)
                        <label class="flex items-center p-4 border border-white/10 rounded-xl cursor-pointer hover:bg-white/5 transition {{ $shipping_method === 'nacional' ? 'border-brand-cyan bg-white/10' : '' }}">
                            <input type="radio" wire:model.live="shipping_method" value="nacional" class="text-brand-cyan focus:ring-brand-cyan bg-transparent border-white/20">
                            <div class="ml-3">
                                <span class="text-white font-bold block">Envío Nacional</span>
                                <span class="text-xs text-gray-400">MRW, Zoom, Tealca (Pago al recibir)</span>
                            </div>
                        </label>
                    @endif
                </div>
            </div>

            <!-- CAMPOS DINÁMICOS SEGÚN EL MÉTODO DE ENVÍO -->
            @if($shipping_method === 'delivery')
                <div class="bg-white/5 border border-white/10 rounded-2xl p-6 backdrop-blur-md" wire:key="delivery-fields-active">
                    <h2 class="text-xl font-bold text-white mb-4">Ubicación de Entrega</h2>
                    <p class="text-sm text-gray-400 mb-4">Haz clic en el mapa para marcar dónde quieres recibir tu pedido.</p>
                    
                    <!-- Contenedor del Mapa con Alpine.js -->
                    <div 
                        x-data="{
                            map: null,
                            marker: null,
                            init() {
                                setTimeout(() => this.initMap(), 150);
                            },
                            initMap() {
                                if (this.map) return;
                                
                                if (!document.querySelector('link[href*=\'leaflet.css\']')) {
                                    let link = document.createElement('link');
                                    link.rel = 'stylesheet';
                                    link.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
                                    document.head.appendChild(link);
                                }
                                
                                this.map = L.map($refs.mapContainer).setView([9.7419, -63.4186], 13);
                                
                                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                    attribution: '© OpenStreetMap'
                                }).addTo(this.map);

                                this.marker = L.marker([9.7419, -63.4186], {draggable: true}).addTo(this.map);

                                this.map.on('click', (e) => {
                                    this.updateLocation(e.latlng.lat, e.latlng.lng);
                                });

                                this.marker.on('dragend', (e) => {
                                    let pos = this.marker.getLatLng();
                                    this.updateLocation(pos.lat, pos.lng);
                                });
                                
                                setTimeout(() => this.map.invalidateSize(), 200);
                            },
                            updateLocation(lat, lng) {
                                this.marker.setLatLng([lat, lng]);
                                $wire.set('latitude', lat);
                                $wire.set('longitude', lng);

                                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                                    .then(res => res.json())
                                    .then(data => {
                                        if (data.display_name) {
                                            $wire.set('customer_address', data.display_name);
                                        }
                                    });
                            }
                        }"
                        x-init="init()"
                        wire:ignore
                        class="relative z-10"
                    >
                        <div x-ref="mapContainer" class="h-72 w-full rounded-xl border border-white/20"></div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm text-gray-400 mb-1">Dirección exacta (auto-completada por el mapa)</label>
                        <input type="text" wire:model="customer_address" placeholder="Haz clic en el mapa..." class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-3 text-white focus:border-brand-cyan focus:outline-none">
                        @error('customer_address') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        @error('latitude') <span class="text-red-400 text-xs mt-1 block">Debes marcar tu ubicación en el mapa.</span> @enderror
                    </div>
                </div>

                @push('scripts')
                <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
                @endpush
            @endif

            @if($shipping_method === 'nacional')
                <div class="bg-white/5 border border-white/10 rounded-2xl p-6 backdrop-blur-md" wire:key="national-fields">
                    <h2 class="text-xl font-bold text-white mb-4">Datos para Envío Nacional</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm text-gray-400 mb-1">Agencia de Envío</label>
                            <select wire:model="national_agency" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-3 text-white focus:border-brand-cyan focus:outline-none">
                                <option value="">Selecciona una agencia</option>
                                @foreach($agencias as $agencia)
                                    <option value="{{ $agencia }}">{{ $agencia }}</option>
                                @endforeach
                            </select>
                            @error('national_agency') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm text-gray-400 mb-1">Ciudad / Estado de Destino</label>
                            <input type="text" wire:model="national_destination" placeholder="Ej: Caracas, Distrito Capital" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-3 text-white focus:border-brand-cyan focus:outline-none">
                            @error('national_destination') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            @endif

            <!-- Personalización y Pago -->
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6 backdrop-blur-md">
                <h2 class="text-xl font-bold text-white mb-4">Personalización y Pago</h2>
                
                <div class="space-y-6">
                    <div class="bg-brand-dark p-4 rounded-xl border border-white/10">
                        <label class="block text-sm font-bold text-brand-cyan mb-2">1. Sube tu Diseño para Sublimar</label>
                        <input type="file" wire:model="customization_file" class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-brand-purple/20 file:text-brand-purple hover:file:bg-brand-purple/30 transition">
                        @error('customization_file') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        <div wire:loading wire:target="customization_file" class="text-brand-cyan text-xs mt-2">Subiendo diseño...</div>
                        @if($customization_file)
                            <img src="{{ $customization_file->temporaryUrl() }}" class="h-20 w-20 object-cover rounded-lg mt-2 border border-white/20">
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Instrucciones adicionales (Opcional)</label>
                        <textarea wire:model="customization_notes" rows="2" placeholder="Ej: Poner el nombre 'María' en letras doradas" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-3 text-white focus:border-brand-cyan focus:outline-none"></textarea>
                    </div>

                    <div class="bg-brand-dark p-4 rounded-xl border border-white/10">
                        <label class="block text-sm font-bold text-brand-cyan mb-2">2. Sube tu Comprobante de Pago</label>
                        <input type="file" wire:model="payment_receipt" class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-brand-cyan/20 file:text-brand-cyan hover:file:bg-brand-cyan/30 transition">
                        @error('payment_receipt') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        <div wire:loading wire:target="payment_receipt" class="text-brand-cyan text-xs mt-2">Subiendo comprobante...</div>
                        @if($payment_receipt)
                            <img src="{{ $payment_receipt->temporaryUrl() }}" class="h-20 w-20 object-cover rounded-lg mt-2 border border-white/20">
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Columna Derecha: Resumen -->
        <div class="md:col-span-1">
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6 sticky top-24 backdrop-blur-md">
                <h2 class="text-lg font-bold text-white mb-4 border-b border-white/10 pb-4">Resumen del Pedido</h2>
                
                <div class="space-y-3 mb-6">
                    @foreach($cart as $item)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">{{ $item['quantity'] }}x {{ $item['name'] }}</span>
                            <span class="text-white">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-white/10 pt-4 mb-6">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-400">Subtotal:</span>
                        <span class="text-white">${{ number_format($totalUsd, 2) }}</span>
                    </div>
                    @if($shipping_cost > 0)
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-400">Envío:</span>
                        <span class="text-white">${{ number_format($shipping_cost, 2) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between items-baseline mt-4 pt-4 border-t border-white/10">
                        <span class="text-white font-bold">Total USD:</span>
                        <span class="text-2xl font-bold text-white">${{ number_format($totalUsd + $shipping_cost, 2) }}</span>
                    </div>
                    @if($tasaBcv > 0)
                        <div class="flex justify-between items-baseline text-brand-cyan mt-2">
                            <span class="text-sm">Total Bs:</span>
                            <span class="font-bold">Bs. {{ number_format(($totalUsd + $shipping_cost) * $tasaBcv, 2) }}</span>
                        </div>
                    @endif
                </div>

                @if($setting && $setting->bankAccounts->where('is_active', true)->count() > 0)
                    <div class="bg-brand-dark rounded-xl p-4 border border-brand-cyan/30 mb-6 max-h-60 overflow-y-auto">
                        <h3 class="text-xs font-bold text-brand-cyan uppercase tracking-wider mb-3">Datos de Pago</h3>
                        <div class="space-y-4">
                            @foreach($setting->bankAccounts->where('is_active', true) as $account)
                                <div class="bg-white/5 p-3 rounded-lg border border-white/10">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-sm font-bold text-white">{{ $account->bank_name }}</span>
                                        <span class="text-[10px] bg-brand-purple/20 text-brand-purple px-2 py-0.5 rounded-full">{{ $account->account_type }}</span>
                                    </div>
                                    @if($account->account_type === 'Pago Móvil')
                                        <div class="text-xs text-gray-300 space-y-0.5">
                                            <p>Tel: {{ $account->phone }}</p>
                                            <p>CI/RIF: {{ $account->id_number }}</p>
                                        </div>
                                    @else
                                        <div class="text-xs text-gray-300">
                                            <p>Cuenta: {{ $account->account_number }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <button wire:click="placeOrder" wire:loading.attr="disabled" class="w-full bg-gradient-to-r from-brand-purple to-brand-cyan hover:from-purple-500 hover:to-cyan-400 text-white font-bold py-3 px-4 rounded-xl transition duration-300 shadow-lg shadow-brand-cyan/30 flex justify-center items-center gap-2 disabled:opacity-50">
                    <span wire:loading.remove wire:target="placeOrder">Confirmar Pedido</span>
                    <span wire:loading wire:target="placeOrder">Procesando...</span>
                </button>
            </div>
        </div>
    </div>
</div>