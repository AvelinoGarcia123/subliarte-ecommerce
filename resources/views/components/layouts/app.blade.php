<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subli-Arte F.P. | Personaliza lo que imaginas</title>
    
    <!-- CDN de Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Configuración personalizada de Tailwind (Animaciones y Colores) -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            purple: '#8b5cf6',
                            cyan: '#06b6d4',
                            dark: '#0f172a',
                            darker: '#020617'
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'float-slow': 'float 8s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'shimmer': 'shimmer 2.5s linear infinite',
                        'fade-in-up': 'fadeInUp 0.8s ease-out forwards',
                        'spin-slow': 'spin 12s linear infinite',
                        'marquee': 'marquee 25s linear infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                        shimmer: {
                            '0%': { backgroundPosition: '-200% 0' },
                            '100%': { backgroundPosition: '200% 0' },
                        },
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        marquee: {
                            '0%': { transform: 'translateX(0)' },
                            '100%': { transform: 'translateX(-50%)' },
                        }
                    }
                }
            }
        }
    </script>

    <!-- Fuente de Google -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Estilos Personalizados -->
    <style> 
        html { scroll-behavior: smooth; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; } 
        
        .bg-grid-pattern {
            background-image: linear-gradient(to right, rgba(255,255,255,0.04) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(255,255,255,0.04) 1px, transparent 1px);
            background-size: 40px 40px;
        }
        
        .text-gradient {
            background: linear-gradient(to right, #8b5cf6, #06b6d4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Efecto Shimmer para botones */
        .shimmer-btn {
            background: linear-gradient(90deg, #8b5cf6 0%, #06b6d4 50%, #8b5cf6 100%);
            background-size: 200% auto;
            color: white;
            animation: shimmer 3s linear infinite;
        }

        /* Ocultar scrollbar horizontal en móviles */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

                /* ✅ Scrollbar Personalizado (Estilo Premium) */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.02); 
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(139, 92, 246, 0.4); /* Morado transparente */
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(6, 182, 212, 0.8); /* Cian al pasar el mouse */
        }
        /* Para Firefox */
        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: rgba(139, 92, 246, 0.4) transparent;
        }
    </style>

    <!-- Leaflet CSS y JS (Para el mapa de Delivery) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>
<body class="bg-brand-dark text-gray-300 flex flex-col min-h-screen antialiased selection:bg-brand-cyan selection:text-white">

    {{-- ✅ Barra de Anuncios / Promociones Animada --}}
    @php $setting = \App\Models\Setting::first(); @endphp
    @if($setting && $setting->promociones)
        <div class="bg-gradient-to-r from-brand-purple via-brand-cyan to-brand-purple text-white py-2 text-xs font-bold tracking-wide shadow-lg relative z-[60] overflow-hidden">
            <div class="flex animate-marquee whitespace-nowrap w-max">
                {{-- Primera tanda de textos --}}
                <div class="flex items-center">
                    @for ($i = 0; $i < 5; $i++)
                        <span class="mx-8 inline-flex items-center gap-2">
                            <span class="animate-pulse">🎉</span>
                            {{ $setting->promociones }}
                            <span class="animate-pulse">🎉</span>
                        </span>
                    @endfor
                </div>
                {{-- Segunda tanda (idéntica para hacer el bucle infinito) --}}
                <div class="flex items-center">
                    @for ($i = 0; $i < 5; $i++)
                        <span class="mx-8 inline-flex items-center gap-2">
                            <span class="animate-pulse">🎉</span>
                            {{ $setting->promociones }}
                            <span class="animate-pulse">🎉</span>
                        </span>
                    @endfor
                </div>
            </div>
        </div>
    @endif

    {{-- Navbar --}}
    <nav class="border-b border-white/10 bg-brand-dark/80 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-brand-purple to-brand-cyan flex items-center justify-center text-white font-black text-xl shadow-lg shadow-brand-purple/30 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">S</div>
                    <span class="text-xl font-extrabold text-white tracking-tight">Subli-Arte</span>
                </a>
                
                {{-- Enlaces Centrales --}}
                <div class="hidden lg:flex items-center space-x-1 text-sm font-medium">
                    <a href="{{ route('home') }}" class="px-4 py-2 rounded-lg transition-all {{ request()->routeIs('home') ? 'text-white bg-white/10' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">Inicio</a>
                    <a href="{{ route('catalogo') }}" class="px-4 py-2 rounded-lg transition-all {{ request()->routeIs('catalogo') ? 'text-white bg-white/10' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">Catálogo</a>
                    <a href="{{ route('home') }}#categorias" class="px-4 py-2 rounded-lg text-gray-400 hover:text-white hover:bg-white/5 transition-all">Categorías</a>
                    <a href="{{ route('home') }}#destacados" class="px-4 py-2 rounded-lg text-gray-400 hover:text-white hover:bg-white/5 transition-all">Novedades</a>
                    <a href="{{ route('home') }}#como-funciona" class="px-4 py-2 rounded-lg text-gray-400 hover:text-white hover:bg-white/5 transition-all">Cómo funciona</a>
                    <a href="{{ route('home') }}#contacto" class="px-4 py-2 rounded-lg text-gray-400 hover:text-white hover:bg-white/5 transition-all">Contacto</a>
                </div>

                {{-- Iconos y Autenticación --}}
                <div class="flex items-center space-x-2 sm:space-x-3">
                    
                    {{-- 1. Carrito Reactivo con Tooltip --}}
                    <div class="relative group flex items-center">
                        <a href="{{ route('cart') }}" class="relative p-2.5 text-gray-400 hover:text-brand-cyan bg-transparent hover:bg-white/10 rounded-full transition-all duration-200 block" x-data="{ cartCount: {{ count(session()->get('cart', [])) }} }" @cart-updated.window="cartCount = $event.detail.count">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            <span x-show="cartCount > 0" x-text="cartCount" class="absolute top-1 right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-gradient-to-r from-brand-purple to-brand-cyan rounded-full group-hover:scale-110 transition-transform"></span>
                        </a>
                        {{-- Tooltip Carrito --}}
                        <div class="absolute top-full left-1/2 transform -translate-x-1/2 mt-1 px-2.5 py-1.5 bg-gray-800 text-white text-[11px] font-medium rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 pointer-events-none whitespace-nowrap z-50 shadow-xl border border-white/10">
                            Carrito
                            <div class="absolute -top-1 left-1/2 transform -translate-x-1/2 w-2 h-2 bg-gray-800 rotate-45 border-t border-l border-white/10"></div>
                        </div>
                    </div>

                    {{-- 2. Campanita del Cliente con Tooltip --}}
                    @auth
                        <div class="relative group flex items-center">
                            {{-- El componente de Livewire ya trae su propio botón y padding --}}
                            <livewire:client-notifications />
                            
                            {{-- Tooltip Notificaciones --}}
                            <div class="absolute top-full left-1/2 transform -translate-x-1/2 mt-1 px-2.5 py-1.5 bg-gray-800 text-white text-[11px] font-medium rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 pointer-events-none whitespace-nowrap z-50 shadow-xl border border-white/10">
                                Notificaciones
                                <div class="absolute -top-1 left-1/2 transform -translate-x-1/2 w-2 h-2 bg-gray-800 rotate-45 border-t border-l border-white/10"></div>
                            </div>
                        </div>
                    @endauth

                    {{-- 3. Menú de Usuario (Dropdown) --}}
                    @auth
                        <div class="relative flex items-center border-l border-white/10 pl-3 ml-1" x-data="{ open: false }">
                            
                            {{-- Botón del Avatar --}}
                            <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2 focus:outline-none group">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-brand-purple to-brand-cyan flex items-center justify-center text-white font-bold shadow-lg shadow-brand-purple/20 group-hover:scale-105 transition-transform">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-white transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            {{-- Menú Desplegable --}}
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                                 class="absolute right-0 top-full mt-2 w-60 bg-gray-900 rounded-2xl shadow-2xl border border-white/10 overflow-hidden z-50" 
                                 style="display: none;">
                                
                                {{-- Info del Usuario --}}
                                <div class="px-5 py-4 bg-white/5 border-b border-white/10">
                                    <p class="text-sm font-bold text-white truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                                </div>

                                {{-- Opciones --}}
                                <div class="p-2 space-y-1">
                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-300 hover:text-white hover:bg-white/10 rounded-xl transition">
                                        <svg class="w-4 h-4 text-brand-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        Configuración de Perfil
                                    </a>
                                    <a href="{{ route('my-orders') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-300 hover:text-white hover:bg-white/10 rounded-xl transition">
                                        <svg class="w-4 h-4 text-brand-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                        Mis Pedidos
                                    </a>
                                </div>

                                {{-- Salir --}}
                                <div class="p-2 border-t border-white/10 bg-white/5">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded-xl transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                            Cerrar Sesión
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-3 border-l border-white/10 pl-4">
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-300 hover:text-white transition hidden sm:inline">Ingresar</a>
                            <a href="{{ route('register') }}" class="bg-gradient-to-r from-brand-purple to-brand-cyan hover:opacity-90 text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-lg shadow-brand-purple/20">Registrarse</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    {{-- Contenido Dinámico --}}
    <main class="flex-grow">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="border-t border-white/10 bg-brand-darker pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
                <div>
                    <a href="{{ route('home') }}" class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-brand-purple to-brand-cyan flex items-center justify-center text-white font-bold">S</div>
                        <span class="text-xl font-bold text-white tracking-tight">Subli-Arte</span>
                    </a>
                    <p class="text-sm text-gray-400 mb-6 leading-relaxed">Transformamos tus ideas en arte personalizado. Tazas, camisas, gorras y más con la mejor calidad de sublimación en Punta de Mata.</p>
                    <p class="text-sm text-gray-500 flex items-center gap-2">
                        <svg class="w-4 h-4 text-brand-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Punta de Mata, Monagas
                    </p>
                </div>

                <div>
                    <h3 class="text-white font-bold mb-4 uppercase tracking-wider text-sm">Enlaces Rápidos</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('home') }}" class="hover:text-brand-cyan transition">Inicio</a></li>
                        <li><a href="{{ route('catalogo') }}" class="hover:text-brand-cyan transition">Catálogo Completo</a></li>
                        <li><a href="{{ route('cart') }}" class="hover:text-brand-cyan transition">Mi Carrito</a></li>
                        @auth
                            <li><a href="{{ route('my-orders') }}" class="hover:text-brand-cyan transition">Mis Pedidos</a></li>
                        @endauth
                    </ul>
                </div>

                <div>
                    <h3 class="text-white font-bold mb-4 uppercase tracking-wider text-sm">Atención al Cliente</h3>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-brand-cyan flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            +58 414-1234567
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-brand-cyan flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            ventas@subliarte.com
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-white font-bold mb-4 uppercase tracking-wider text-sm">Síguenos</h3>
                    <p class="text-sm text-gray-400 mb-4">Entérate de nuestras promociones.</p>
                    @if($setting)
                    <div class="flex space-x-3">
                        @if($setting->instagram)
                            <a href="https://instagram.com/{{ $setting->instagram }}" target="_blank" class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-gradient-to-tr hover:from-pink-500 hover:to-yellow-500 transition-all duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                            </a>
                        @endif
                        @if($setting->whatsapp)
                            <a href="https://wa.me/{{ $setting->whatsapp }}" target="_blank" class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-green-500 transition-all duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                            </a>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-gray-500">
                <p>&copy; {{ date('Y') }} Subli-Arte F.P. Todos los derechos reservados.</p>
                <div class="flex items-center gap-2">
                    <span>Hecho con</span>
                    <svg class="w-4 h-4 text-red-500 animate-pulse" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                    <span>en Venezuela</span>
                </div>
            </div>
        </div>
    </footer>

    <livewire:client-chat />
</body>
</html>