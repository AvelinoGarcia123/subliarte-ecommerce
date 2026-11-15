<div>
    {{-- HERO SECTION --}}
    <div class="relative bg-brand-darker bg-grid-pattern border-b border-white/5 overflow-hidden">
        {{-- Brillos flotantes animados --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-20 left-1/4 w-96 h-96 bg-brand-purple/20 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-brand-cyan/20 rounded-full blur-3xl animate-float" style="animation-delay: -3s"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                
                {{-- Texto Izquierda --}}
                <div>
                    <div class="inline-flex items-center gap-2 py-1.5 px-4 rounded-full bg-white/5 border border-white/10 text-brand-cyan text-xs font-bold mb-8">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-cyan opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-cyan"></span>
                        </span>
                        Sublimación Premium en Monagas
                    </div>
                    
                    <h1 class="text-5xl lg:text-7xl font-black text-white leading-[1.1] mb-6">
                        Dale vida a <br>
                        <span class="text-gradient">tus ideas.</span>
                    </h1>
                    
                    <p class="text-lg text-gray-400 mb-10 max-w-lg leading-relaxed">
                        Creamos productos únicos con la mejor calidad de sublimación. Tazas, franelas, gorras y mucho más, personalizados a tu estilo.
                    </p>

                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('catalogo') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-brand-purple to-brand-cyan hover:shadow-2xl hover:shadow-brand-cyan/30 text-white font-bold py-4 px-8 rounded-xl transition-all duration-300 transform hover:scale-105">
                            Ver Catálogo
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                        <a href="{{ route('home') }}#como-funciona" class="inline-flex items-center gap-2 bg-white/5 hover:bg-white/10 border border-white/10 text-white font-bold py-4 px-8 rounded-xl transition-all duration-300">
                            Cómo funciona
                        </a>
                    </div>

                    {{-- Trust Badges --}}
                    <div class="mt-12 flex flex-wrap gap-8">
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 rounded-lg bg-green-500/10 flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <p class="text-white font-bold text-sm">Envíos</p>
                                <p class="text-gray-500 text-xs">A todo el país</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 rounded-lg bg-brand-cyan/10 flex items-center justify-center">
                                <svg class="w-5 h-5 text-brand-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-white font-bold text-sm">Calidad</p>
                                <p class="text-gray-500 text-xs">Garantizada</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 rounded-lg bg-brand-purple/10 flex items-center justify-center">
                                <svg class="w-5 h-5 text-brand-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-white font-bold text-sm">Pago</p>
                                <p class="text-gray-500 text-xs">Móvil / Transf.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Visual Derecha --}}
                <div class="relative">
                    <div class="absolute -inset-4 bg-gradient-to-r from-brand-purple to-brand-cyan opacity-20 blur-3xl"></div>
                    <div class="relative bg-white/5 border border-white/10 rounded-3xl p-6 backdrop-blur-md">
                        <div class="grid grid-cols-2 gap-4">
                            @foreach($destacados->take(4) as $producto)
                                <a href="{{ route('product.detail', $producto->id) }}" class="relative aspect-square rounded-2xl overflow-hidden bg-gray-800 group">
                                    @if($producto->image_path)
                                        <img src="{{ asset('storage/' . $producto->image_path) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                                    <div class="absolute bottom-2 left-2 right-2">
                                        <p class="text-white text-xs font-bold truncate">{{ $producto->name }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SECCIÓN DE CATEGORÍAS --}}
    <section id="categorias" class="py-24 bg-brand-dark">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-4xl font-extrabold text-white mb-3">Explora por Categorías</h2>
                    <p class="text-gray-400">Encuentra el producto perfecto para tu próximo diseño.</p>
                </div>
                <a href="{{ route('catalogo') }}" class="hidden md:inline-flex items-center gap-2 text-brand-cyan hover:text-white font-bold transition">
                    Ver todo <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($categorias as $categoria)
                    <a href="{{ route('catalogo', ['category' => $categoria->id]) }}" class="group relative bg-white/5 border border-white/10 rounded-2xl p-8 text-center hover:bg-white/10 hover:border-brand-cyan/50 transition-all duration-300 overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-brand-purple/0 to-brand-cyan/0 group-hover:from-brand-purple/10 group-hover:to-brand-cyan/10 transition-all"></div>
                        <div class="relative">
                            <div class="w-16 h-16 mx-auto bg-gradient-to-tr from-brand-purple/20 to-brand-cyan/20 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                                <svg class="w-8 h-8 text-brand-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                            <h3 class="text-xl font-extrabold text-white mb-1 capitalize">{{ $categoria->name }}</h3>
                            <p class="text-sm text-gray-400">{{ $categoria->products_count }} productos</p>
                        </div>
                    </a>
                @empty
                    <div class="col-span-4 text-center text-gray-500 py-10">Aún no hay categorías registradas.</div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- SECCIÓN DE PRODUCTOS DESTACADOS / NOVEDADES --}}
    @if($destacados->count() > 0)
    <section id="destacados" class="py-24 bg-brand-darker border-y border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <div class="inline-flex items-center gap-2 py-1 px-3 rounded-full bg-brand-cyan/10 text-brand-cyan text-xs font-bold mb-3">
                        ✨ Novedades
                    </div>
                    <h2 class="text-4xl font-extrabold text-white mb-3">Lo más nuevo</h2>
                    <p class="text-gray-400">Los últimos productos que agregamos a nuestra tienda.</p>
                </div>
                <a href="{{ route('catalogo') }}" class="hidden md:inline-flex items-center gap-2 text-brand-cyan hover:text-white font-bold transition">
                    Ver todo <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($destacados as $producto)
                    <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden flex flex-col group hover:border-brand-cyan/50 transition-colors duration-300">
                        <a href="{{ route('product.detail', $producto->id) }}" class="block aspect-square bg-gray-800 relative overflow-hidden">
                            @if($producto->image_path)
                                <img src="{{ asset('storage/' . $producto->image_path) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @endif
                            <div class="absolute top-3 left-3 bg-gradient-to-r from-brand-purple to-brand-cyan text-white text-[10px] font-black uppercase px-2 py-1 rounded-md shadow-lg">Nuevo</div>
                        </a>
                        <div class="p-5 flex flex-col flex-grow">
                            <span class="text-[10px] uppercase tracking-wider text-brand-cyan font-bold mb-1">{{ $producto->category->name }}</span>
                            <a href="{{ route('product.detail', $producto->id) }}">
                                <h3 class="text-base font-bold text-white mb-2 line-clamp-1 group-hover:text-brand-cyan transition-colors">{{ $producto->name }}</h3>
                            </a>
                            <div class="mt-auto flex justify-between items-center">
                                <span class="text-lg font-extrabold text-white">${{ number_format($producto->price, 2) }}</span>
                                <a href="{{ route('product.detail', $producto->id) }}" class="w-8 h-8 rounded-full bg-white/10 hover:bg-brand-cyan text-white flex items-center justify-center transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- SECCIÓN CÓMO FUNCIONA --}}
    <section id="como-funciona" class="py-24 bg-brand-dark relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-extrabold text-white mb-4">¿Cómo funciona?</h2>
                <p class="text-gray-400 text-lg max-w-2xl mx-auto">Personalizar tus productos nunca fue tan fácil. Solo 4 simples pasos.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Paso 1 -->
                <div class="bg-white/5 border border-white/10 p-8 rounded-2xl relative group hover:border-brand-cyan/50 hover:bg-white/10 transition duration-300">
                    <div class="w-14 h-14 bg-gradient-to-tr from-brand-cyan/20 to-brand-cyan/5 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <svg class="w-7 h-7 text-brand-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <div class="absolute top-6 right-6 text-5xl font-black text-white/5 group-hover:text-brand-cyan/10 transition">1</div>
                    <h3 class="text-lg font-bold text-white mb-2">Elige tu producto</h3>
                    <p class="text-sm text-gray-400">Explora nuestro catálogo y selecciona lo que más te guste.</p>
                </div>
                <!-- Paso 2 -->
                <div class="bg-white/5 border border-white/10 p-8 rounded-2xl relative group hover:border-brand-cyan/50 hover:bg-white/10 transition duration-300">
                    <div class="w-14 h-14 bg-gradient-to-tr from-brand-purple/20 to-brand-purple/5 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <svg class="w-7 h-7 text-brand-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    </div>
                    <div class="absolute top-6 right-6 text-5xl font-black text-white/5 group-hover:text-brand-purple/10 transition">2</div>
                    <h3 class="text-lg font-bold text-white mb-2">Sube tu diseño</h3>
                    <p class="text-sm text-gray-400">Carga la imagen que quieres sublimar en tu producto.</p>
                </div>
                <!-- Paso 3 -->
                <div class="bg-white/5 border border-white/10 p-8 rounded-2xl relative group hover:border-brand-cyan/50 hover:bg-white/10 transition duration-300">
                    <div class="w-14 h-14 bg-gradient-to-tr from-green-500/20 to-green-500/5 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <svg class="w-7 h-7 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div class="absolute top-6 right-6 text-5xl font-black text-white/5 group-hover:text-green-500/10 transition">3</div>
                    <h3 class="text-lg font-bold text-white mb-2">Paga fácil</h3>
                    <p class="text-sm text-gray-400">Por Pago Móvil o transferencia. Sube tu comprobante.</p>
                </div>
                <!-- Paso 4 -->
                <div class="bg-white/5 border border-white/10 p-8 rounded-2xl relative group hover:border-brand-cyan/50 hover:bg-white/10 transition duration-300">
                    <div class="w-14 h-14 bg-gradient-to-tr from-yellow-500/20 to-yellow-500/5 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <svg class="w-7 h-7 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                    </div>
                    <div class="absolute top-6 right-6 text-5xl font-black text-white/5 group-hover:text-yellow-500/10 transition">4</div>
                    <h3 class="text-lg font-bold text-white mb-2">Recibe tu arte</h3>
                    <p class="text-sm text-gray-400">Retiro en tienda, delivery o envío nacional.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA BANNER FINAL --}}
    <section class="py-20 px-4">
        <div class="max-w-6xl mx-auto relative rounded-3xl overflow-hidden bg-gradient-to-br from-brand-purple to-brand-cyan p-12 md:p-16 text-center shadow-2xl shadow-brand-purple/30">
            <div class="absolute inset-0 bg-grid-pattern opacity-20"></div>
            <div class="relative z-10">
                <h2 class="text-4xl md:text-5xl font-black text-white mb-4">¿Listo para crear algo único?</h2>
                <p class="text-white/80 text-lg mb-8 max-w-2xl mx-auto">Explora nuestro catálogo y empieza a diseñar tu próxima obra de arte.</p>
                <a href="{{ route('catalogo') }}" class="inline-flex items-center gap-2 bg-white text-brand-dark font-bold py-4 px-10 rounded-xl hover:bg-gray-100 transition shadow-xl transform hover:scale-105">
                    Ir al Catálogo
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
        </div>
    </section>

    {{-- SECCIÓN DE CONTACTO --}}
    <section id="contacto" class="py-24 bg-brand-darker">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-extrabold text-white mb-4">Contáctanos</h2>
                <p class="text-gray-400 text-lg">Estamos aquí para ayudarte con tu diseño.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white/5 border border-white/10 rounded-2xl p-8 backdrop-blur-md space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-brand-cyan/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-brand-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-white font-bold text-lg mb-1">Teléfono / WhatsApp</h3>
                            <p class="text-gray-400">+58 414-1234567</p>
                            <p class="text-gray-500 text-sm">Lun - Vie: 8:00 AM - 5:00 PM</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-brand-purple/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-brand-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-white font-bold text-lg mb-2">Redes Sociales</h3>
                            <div class="flex gap-3">
                                @php $setting = \App\Models\Setting::first(); @endphp
                                @if($setting && $setting->instagram)<a href="https://instagram.com/{{ $setting->instagram }}" target="_blank" class="text-sm text-gray-400 hover:text-brand-cyan transition">Instagram</a>@endif
                                @if($setting && $setting->facebook)<a href="https://facebook.com/{{ $setting->facebook }}" target="_blank" class="text-sm text-gray-400 hover:text-brand-cyan transition">Facebook</a>@endif
                                @if($setting && $setting->whatsapp)<a href="https://wa.me/{{ $setting->whatsapp }}" target="_blank" class="text-sm text-gray-400 hover:text-brand-cyan transition">WhatsApp</a>@endif
                            </div>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-green-500/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-white font-bold text-lg mb-1">Ubicación de la Tienda</h3>
                            <p class="text-gray-400">Casco Central, Punta de Mata, Estado Monagas.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white/5 border border-white/10 rounded-2xl p-2 backdrop-blur-md h-[400px]">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15657.913468551782!2d-63.41867319372935!3d9.741927049879683!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8c32882007393277%3A0x4db81f07a77e26cb!2sPunta%20de%20Mata%2C%20Monagas%2C%20Venezuela!5e0!3m2!1ses!2sus!4v1700000000000!5m2!1ses!2sus" width="100%" height="100%" style="border:0; border-radius: 0.75rem; filter: invert(0.9) hue-rotate(180deg);" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </section>
</div>