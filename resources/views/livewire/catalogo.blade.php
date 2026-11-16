<div class="max-w-7xl mx-auto px-4 py-12 min-h-screen">
    
    {{-- Header del Catálogo --}}
    <div class="mb-10 text-center">
        <h1 class="text-4xl md:text-5xl font-black text-white mb-4">Nuestro Catálogo</h1>
        <p class="text-gray-400 mb-8 max-w-xl mx-auto">Descubre todos nuestros productos y personalízalos a tu gusto.</p>
        
        {{-- Buscador --}}
        <div class="relative max-w-xl mx-auto z-50">
            <div class="flex items-center bg-white/5 border border-white/10 rounded-xl p-2 backdrop-blur-sm focus-within:border-brand-cyan focus-within:ring-1 focus-within:ring-brand-cyan transition">
                <svg class="w-5 h-5 text-gray-400 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Busca tazas, franelas, gorras..." class="bg-transparent border-none text-white w-full px-3 focus:outline-none">
                @if($search)
                    <button wire:click="$set('search', '')" class="text-gray-400 hover:text-white px-2 mr-2">✕</button>
                @endif
            </div>
            
            {{-- Autocompletado --}}
            @if($search)
                <div class="absolute top-full left-0 right-0 mt-2 bg-gray-900 border border-white/10 rounded-xl shadow-2xl overflow-hidden z-[100] text-left">
                    @forelse($quickResults as $result)
                        <a href="{{ route('product.detail', $result->id) }}" class="flex items-center p-3 hover:bg-white/5 border-b border-white/5 last:border-0">
                            <div class="w-10 h-10 rounded-lg bg-gray-800 overflow-hidden mr-3">
                                @if($result->image_path)<img src="{{ asset('storage/' . $result->image_path) }}" class="w-full h-full object-cover">@endif
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-white">{{ $result->name }}</p>
                                <p class="text-xs text-gray-500">{{ $result->category->name }}</p>
                            </div>
                            <p class="text-sm font-bold text-brand-cyan">${{ number_format($result->price, 2) }}</p>
                        </a>
                    @empty
                        <div class="p-4 text-center text-gray-400 text-sm">No hay resultados para "{{ $search }}"</div>
                    @endforelse
                </div>
            @endif
        </div>
        
        @if($tasaBcv > 0)
            <div class="mt-6 inline-block text-sm text-gray-400 bg-white/5 border border-white/10 px-4 py-2 rounded-lg">
                Tasa BCV: <span class="font-bold text-brand-cyan">{{ number_format($tasaBcv, 2) }} Bs/$</span>
            </div>
        @endif
    </div>

    {{-- Píldoras de Categorías --}}
    <div class="flex items-center justify-center flex-wrap gap-2 mb-10 overflow-x-auto no-scrollbar py-2">
        <button wire:click="filterByCategory(null)" 
                class="px-5 py-2 rounded-full text-sm font-bold transition-all whitespace-nowrap {{ $selectedCategory === null ? 'bg-gradient-to-r from-brand-purple to-brand-cyan text-white shadow-lg' : 'bg-white/5 text-gray-400 hover:bg-white/10 hover:text-white' }}">
            Todos
        </button>
        @foreach($categorias as $cat)
            <button wire:click="filterByCategory({{ $cat->id }})" 
                    class="px-5 py-2 rounded-full text-sm font-bold transition-all whitespace-nowrap {{ $selectedCategory == $cat->id ? 'bg-gradient-to-r from-brand-purple to-brand-cyan text-white shadow-lg' : 'bg-white/5 text-gray-400 hover:bg-white/10 hover:text-white' }}">
                {{ $cat->name }}
            </button>
        @endforeach
    </div>

    {{-- Grilla de Productos --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        @forelse($productos as $producto)
                <div wire:key="product-{{ $producto->id }}" class="bg-white/5 border border-white/10 rounded-2xl shadow-sm hover:shadow-2xl hover:shadow-brand-cyan/20 hover:border-brand-cyan/50 transition-all duration-500 overflow-hidden flex flex-col group transform hover:-translate-y-2">
                
                <a href="{{ route('product.detail', $producto->id) }}" class="block aspect-square w-full bg-gray-800 relative overflow-hidden">
                    @if($producto->image_path)
                        <img src="{{ asset('storage/' . $producto->image_path) }}" alt="{{ $producto->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    @else
                        <div class="flex items-center justify-center h-full text-gray-500">Sin imagen</div>
                    @endif
                    
                    {{-- Efecto de brillo en hover --}}
                    <div class="absolute inset-0 bg-gradient-to-tr from-white/0 via-white/20 to-white/0 opacity-0 group-hover:opacity-100 transition-opacity duration-700 transform -translate-x-full group-hover:translate-x-full"></div>

                    <span class="absolute top-3 left-3 bg-gradient-to-r from-brand-purple to-brand-cyan text-white text-[10px] font-black uppercase px-2 py-1 rounded-md shadow">Nuevo</span>
                    <span class="absolute top-3 right-3 bg-brand-dark/80 backdrop-blur text-brand-cyan text-[10px] font-bold px-2 py-1 rounded-full border border-white/10 uppercase">
                        {{ $producto->category->name }}
                    </span>
                </a>

                <div class="p-5 flex flex-col flex-grow">
                    <a href="{{ route('product.detail', $producto->id) }}">
                        <h3 class="text-lg font-bold text-white mb-2 hover:text-brand-cyan transition line-clamp-1">{{ $producto->name }}</h3>
                    </a>
                    <p class="text-gray-400 text-sm mb-4 flex-grow line-clamp-2">{{ $producto->description }}</p>
                    
                    <div class="mt-auto border-t border-white/10 pt-4">
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-2xl font-extrabold text-white">${{ number_format($producto->price, 2) }}</span>
                            @if($producto->stock > 0)
                                <span class="text-[10px] text-green-400 font-bold bg-green-400/10 px-2 py-1 rounded uppercase">En Stock</span>
                            @else
                                <span class="text-[10px] text-red-400 font-bold bg-red-400/10 px-2 py-1 rounded uppercase">Agotado</span>
                            @endif
                        </div>
                        <button wire:click.prevent="addToCart({{ $producto->id }})" 
                                class="w-full bg-white/10 hover:bg-gradient-to-r hover:from-brand-purple hover:to-brand-cyan text-white font-bold py-2.5 rounded-xl transition-all duration-300 transform hover:scale-105 {{ $producto->stock <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}" 
                                {{ $producto->stock <= 0 ? 'disabled' : '' }}>
                            Añadir al Carrito
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-20 bg-white/5 rounded-2xl border border-white/10">
                <svg class="w-20 h-20 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <h2 class="text-2xl font-bold text-white mb-2">No encontramos resultados</h2>
                <p class="text-gray-400 mb-6">Intenta con otra búsqueda o categoría.</p>
                <button wire:click="$set('search', ''); filterByCategory(null)" class="bg-white/10 hover:bg-white/20 text-white px-6 py-2 rounded-lg font-bold transition">
                    Ver todo el catálogo
                </button>
            </div>
        @endforelse
    </div>
</div>