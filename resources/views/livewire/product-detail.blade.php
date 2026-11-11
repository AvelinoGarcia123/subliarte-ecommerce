<div class="max-w-7xl mx-auto px-4 py-8 min-h-screen">
    
    <!-- Breadcrumbs (Migas de pan) -->
    <nav class="flex text-sm text-gray-400 mb-6">
        <a href="/" class="hover:text-brand-cyan transition">Catálogo</a>
        <span class="mx-2">></span>
        <a href="#" class="hover:text-brand-cyan transition">{{ $product->category->name }}</a>
        <span class="mx-2">></span>
        <span class="text-white">{{ $product->name }}</span>
    </nav>

    <!-- Contenedor Principal -->
    <div class="bg-white/5 border border-white/10 rounded-2xl p-6 lg:p-10 backdrop-blur-md">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            
            <!-- Lado Izquierdo: Galería de Imágenes -->
            <div class="flex gap-4">
                <!-- Miniaturas (Falsas por ahora, para dar el efecto) -->
                <div class="flex flex-col gap-3 w-20 flex-shrink-0">
                    <div class="border-2 border-brand-cyan rounded-lg overflow-hidden cursor-pointer">
                        <img src="{{ asset('storage/' . $product->image_path) }}" class="w-full h-20 object-cover">
                    </div>
                    <div class="border border-white/10 rounded-lg overflow-hidden opacity-50 hover:opacity-100 transition cursor-pointer">
                        <img src="{{ asset('storage/' . $product->image_path) }}" class="w-full h-20 object-cover grayscale">
                    </div>
                    <div class="border border-white/10 rounded-lg overflow-hidden opacity-50 hover:opacity-100 transition cursor-pointer">
                        <img src="{{ asset('storage/' . $product->image_path) }}" class="w-full h-20 object-cover">
                    </div>
                </div>

                <!-- Imagen Principal -->
                <div class="flex-1 bg-white rounded-xl flex items-center justify-center overflow-hidden">
                    @if($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" class="w-full h-auto max-h-[500px] object-contain">
                    @else
                        <div class="text-gray-400">Sin imagen disponible</div>
                    @endif
                </div>
            </div>

            <!-- Lado Derecho: Información y Compra -->
            <div class="flex flex-col">
                <p class="text-gray-400 text-sm mb-2">Nuevo | +{{ rand(5, 30) }} vendidos</p>
                <h1 class="text-3xl lg:text-4xl font-extrabold text-white mb-4 leading-tight">{{ $product->name }}</h1>
                
                <!-- Estrellas (Falsas por ahora) -->
                <div class="flex items-center gap-2 mb-6">
                    <div class="flex text-yellow-400 text-lg">★★★★★</div>
                    <span class="text-gray-400 text-sm">({{ rand(3, 15) }})</span>
                </div>

                <!-- Estado del Stock -->
                <div class="mb-4">
                    @if($product->stock > 0)
                        <span class="bg-brand-cyan/20 text-brand-cyan px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide border border-brand-cyan/30">
                            ¡Últimas {{ $product->stock }} unidades!
                        </span>
                    @else
                        <span class="bg-red-500/20 text-red-400 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide border border-red-500/30">
                            Agotado
                        </span>
                    @endif
                </div>

                <!-- Precios -->
                <div class="mb-6">
                    <div class="flex items-baseline gap-2">
                        <span class="text-5xl font-extrabold text-white">${{ number_format($product->price, 2) }}</span>
                        <span class="text-gray-400 text-lg">USD</span>
                    </div>
                    @if($tasaBcv > 0)
                        <p class="text-xl text-brand-cyan font-semibold mt-1">
                            Bs. {{ number_format($product->price * $tasaBcv, 2) }}
                        </p>
                    @endif
                </div>

                <!-- Descripción Corta -->
                <p class="text-gray-300 mb-8 leading-relaxed">
                    {{ $product->description ?? 'Producto de alta calidad listo para personalizar con tu diseño. Sublimación duradera y colores vibrantes.' }}
                </p>

                <!-- Botón de Compra -->
                <div class="mt-auto">
                    <button wire:click="addToCart" 
                        class="w-full bg-gradient-to-r from-brand-purple to-brand-cyan hover:from-purple-500 hover:to-cyan-400 text-white font-bold py-4 px-8 rounded-xl transition duration-300 shadow-lg shadow-brand-cyan/30 text-lg flex justify-center items-center gap-2 {{ $product->stock <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}" 
                        {{ $product->stock <= 0 ? 'disabled' : '' }}>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Añadir al Carrito
                    </button>
                </div>

                <!-- Información Extra -->
                <div class="mt-8 pt-6 border-t border-white/10 space-y-3 text-sm text-gray-400">
                    <p class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Sublimación de alta definición
                    </p>
                    <p class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Pago Móvil y Transferencia disponibles
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>