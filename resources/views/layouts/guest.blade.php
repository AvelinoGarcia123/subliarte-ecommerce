<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Subli-Arte') }}</title>

        <!-- Fuentes y Tailwind -->
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
    <body class="bg-brand-darker text-gray-300 antialiased selection:bg-brand-cyan selection:text-white">
        
        <!-- Fondo con efectos -->
        <div class="fixed inset-0 bg-grid-pattern z-0"></div>
        <div class="fixed top-0 left-1/4 w-96 h-96 bg-brand-purple/20 rounded-full blur-3xl z-0"></div>
        <div class="fixed bottom-0 right-1/4 w-96 h-96 bg-brand-cyan/20 rounded-full blur-3xl z-0"></div>

        <!-- Contenido Centrado -->
        <div class="relative z-10 min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            
            <!-- Logo -->
            <div class="mb-8">
                <a href="/" class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-brand-purple to-brand-cyan flex items-center justify-center text-white font-black text-2xl shadow-lg shadow-brand-purple/50">S</div>
                    <span class="text-3xl font-bold text-white tracking-wide">Subli-Arte</span>
                </a>
            </div>

            <!-- Caja del Formulario (Efecto Vidrio) -->
            <div class="w-full sm:max-w-md px-8 py-10 bg-white/5 backdrop-blur-xl border border-white/10 shadow-2xl overflow-hidden sm:rounded-3xl">
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-sm text-gray-500">
                <a href="/" class="hover:text-brand-cyan transition">&larr; Volver al catálogo</a>
            </div>
        </div>
    </body>
</html>
