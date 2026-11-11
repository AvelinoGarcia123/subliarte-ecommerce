<div>
    <!-- Hero Section (Sección de Bienvenida Oscura) -->
    <div class="relative bg-brand-darker overflow-hidden bg-grid-pattern border-b border-white/5">
        <!-- Resplandores de fondo -->
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-brand-purple/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-brand-cyan/20 rounded-full blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                
                <!-- Texto Izquierda -->
                <div>
                    <span class="inline-block py-1 px-3 rounded-full bg-white/5 border border-white/10 text-brand-cyan text-xs font-semibold mb-6">
                        ✨ Sublimación de alta definición
                    </span>
                    <h1 class="text-5xl lg:text-7xl font-extrabold text-white leading-tight mb-6">
                        Personaliza <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-purple to-brand-cyan">lo que</span> imaginas con colores que no se borran.
                    </h1>
                    <p class="text-lg text-gray-400 mb-8 max-w-lg">
                        Tu diseño alcanza de un clip. Tazas, franelas, gorras y más con la mejor calidad de Punta de Mata.
                    </p>

                    <!-- Barra de Búsqueda -->
                    <div class="flex items-center bg-white/5 border border-white/10 rounded-xl p-2 max-w-lg backdrop-blur-sm">
                        <svg class="w-5 h-5 text-gray-400 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" placeholder="Busca tazas, franelas, gorras..." class="bg-transparent border-none text-white w-full px-3 focus:outline-none placeholder-gray-500">
                        <button class="bg-brand-cyan hover:bg-cyan-500 text-brand-darker font-bold px-6 py-2 rounded-lg transition">Buscar</button>
                    </div>
                </div>

                <!-- Imágenes Derecha (Mosaico) -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-4">
                        <div class="bg-gray-800 rounded-2xl h-64 overflow-hidden relative group">
                            <img src="https://images.unsplash.com/photo-1514228742587-6b1558fcca3d?q=80&w=1000&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" alt="Taza">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex items-end p-4">
                                <p class="text-white font-semibold">Tazas Mágicas</p>
                            </div>
                        </div>
                        <div class="bg-gray-800 rounded-2xl h-48 overflow-hidden relative group">
                            <img src="https://images.unsplash.com/photo-1588850561407-ed78c282e89b?q=80&w=1000&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" alt="Gorra">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex items-end p-4">
                                <p class="text-white font-semibold">Gorras</p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4 pt-12">
                        <div class="bg-gray-800 rounded-2xl h-48 overflow-hidden relative group">
                            <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=1000&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" alt="Franela">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex items-end p-4">
                                <p class="text-white font-semibold">Franelas</p>
                            </div>
                        </div>
                        <div class="bg-gray-800 rounded-2xl h-64 overflow-hidden relative group border border-brand-cyan/30">
                            <img src="https://images.unsplash.com/photo-1577937927133-66ef06acdf18?q=80&w=1000&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" alt="Taza Personalizada">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex items-end p-4">
                                <p class="text-white font-semibold">Diseños Únicos</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Catálogo de Productos -->
    <div class="max-w-7xl mx-auto px-4 py-20">
        <div class="flex justify-between items-end mb-10 border-b border-white/10 pb-4">
            <div>
                <h2 class="text-3xl font-bold text-white mb-2">Nuestro Catálogo</h2>
                <p class="text-gray-400">Elige tu producto y personalízalo a tu gusto.</p>
            </div>
            @if($tasaBcv > 0)
                <div class="text-sm text-gray-400 bg-white/5 border border-white/10 px-4 py-2 rounded-lg">
                    Tasa BCV: <span class="font-bold text-brand-cyan">{{ number_format($tasaBcv, 2) }} Bs/$</span>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($productos as $producto)
                <!-- ✅ TARJETA ENVUELTA EN UN ENLACE AL DETALLE -->
                <a href="{{ route('product.detail', $producto->id) }}" class="bg-white/5 border border-white/10 rounded-2xl shadow-lg hover:border-brand-cyan/50 transition duration-300 overflow-hidden flex flex-col group cursor-pointer">
                    <!-- Imagen -->
                    <div class="h-56 w-full bg-gray-800 relative overflow-hidden">
                        @if($producto->image_path)
                            <img src="{{ asset('storage/' . $producto->image_path) }}" alt="{{ $producto->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="flex items-center justify-center h-full text-gray-500">Sin imagen</div>
                        @endif
                        
                        <span class="absolute top-3 right-3 bg-brand-dark/80 backdrop-blur text-brand-cyan text-xs font-bold px-3 py-1 rounded-full border border-white/10">
                            {{ $producto->category->name }}
                        </span>
                    </div>

                    <!-- Detalles -->
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-lg font-bold text-white mb-2">{{ $producto->name }}</h3>
                        <p class="text-gray-400 text-sm mb-4 flex-grow line-clamp-2">{{ $producto->description }}</p>
                        
                        <div class="mt-auto border-t border-white/10 pt-4">
                            <div class="flex justify-between items-baseline mb-1">
                                <span class="text-xl font-extrabold text-white">${{ number_format($producto->price, 2) }}</span>
                                @if($producto->stock > 0)
                                    <span class="text-xs text-green-400 font-semibold bg-green-400/10 px-2 py-1 rounded">En Stock</span>
                                @else
                                    <span class="text-xs text-red-400 font-semibold bg-red-400/10 px-2 py-1 rounded">Agotado</span>
                                @endif
                            </div>
                            
                            @if($tasaBcv > 0)
                                <div class="text-xs text-gray-500 mb-4">
                                    Bs. {{ number_format($producto->price * $tasaBcv, 2) }}
                                </div>
                            @endif

                            <!-- ✅ BOTÓN CON .prevent PARA QUE NO RECARGUE LA PÁGINA NI NOS SAQUE DEL CATÁLOGO -->
                            <button wire:click.prevent="addToCart({{ $producto->id }})" class="w-full bg-white/10 hover:bg-brand-purple text-white font-bold py-2 px-4 rounded-xl transition duration-200 {{ $producto->stock <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $producto->stock <= 0 ? 'disabled' : '' }}>
                                Añadir al Carrito
                            </button>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>