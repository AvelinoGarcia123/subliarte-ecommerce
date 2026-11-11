<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subli-Arte F.P. | Personaliza lo que imaginas</title>
    <!-- CDN de Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
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
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style> 
        body { font-family: 'Plus Jakarta Sans', sans-serif; } 
        .bg-grid-pattern {
            background-image: linear-gradient(to right, rgba(255,255,255,0.05) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(255,255,255,0.05) 1px, transparent 1px);
            background-size: 40px 40px;
        }
    </style>
</head>
<body class="bg-brand-dark text-gray-300 flex flex-col min-h-screen antialiased selection:bg-brand-cyan selection:text-white">

    <!-- Menú de Navegación -->
    <nav class="border-b border-white/10 bg-brand-dark/80 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                
                <!-- Logo -->
                <a href="/" class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-brand-purple to-brand-cyan flex items-center justify-center text-white font-bold">S</div>
                    <span class="text-xl font-bold text-white tracking-wide">Subli-Arte</span>
                </a>
                
                <!-- Enlaces Centrales -->
                <div class="hidden md:flex items-center space-x-8 text-sm font-medium">
                    <a href="/" class="text-white hover:text-brand-cyan transition">Catálogo</a>
                    <a href="#" class="text-gray-400 hover:text-white transition">Categorías</a>
                    <a href="#" class="text-gray-400 hover:text-white transition">Destacados</a>
                    <a href="#" class="text-gray-400 hover:text-white transition">Cómo funciona</a>
                    <a href="#" class="text-gray-400 hover:text-white transition">Contacto</a>
                </div>

                <!-- Iconos y Autenticación -->
                <div class="flex items-center space-x-4">
                    <!-- Carrito -->
                    <a href="/carrito" class="relative p-2 text-gray-400 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </a>

                    @auth
                        <div class="flex items-center gap-4">
                            <a href="/mis-pedidos" class="text-sm text-gray-300 hover:text-white">Mis Pedidos</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-sm text-red-400 hover:text-red-300">Salir</button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-300 hover:text-white transition">Ingresar</a>
                        <a href="{{ route('register') }}" class="bg-white/10 hover:bg-white/20 border border-white/10 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Registrarse
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Pie de Página -->
    <footer class="border-t border-white/10 py-8 text-center text-sm text-gray-500">
        <p>© 2026 Subli-Arte F.P. - Punta de Mata, Monagas.</p>
    </footer>
</body>
</html>