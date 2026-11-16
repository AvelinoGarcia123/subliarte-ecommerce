<x-layouts.app>
    <div class="min-h-[70vh] flex items-center justify-center bg-brand-darker px-4 py-20 relative overflow-hidden">
        {{-- Brillos de fondo --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-brand-purple/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-brand-cyan/20 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 text-center max-w-2xl mx-auto">
            {{-- Icono Animado --}}
            <div class="mb-8 relative inline-block">
                <div class="absolute inset-0 bg-brand-purple blur-2xl opacity-30 animate-pulse"></div>
                <svg class="w-32 h-32 text-brand-cyan relative z-10 animate-float" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            {{-- Número 404 con Gradiente --}}
            <h1 class="text-8xl md:text-9xl font-black text-transparent bg-clip-text bg-gradient-to-r from-brand-purple to-brand-cyan mb-4">
                404
            </h1>

            {{-- Mensaje --}}
            <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-4">
                ¡Ups! Página no encontrada
            </h2>
            <p class="text-lg text-gray-400 mb-8 leading-relaxed">
                Parece que el diseño que estás buscando no existe o fue movido a otra dirección. Pero no te preocupes, ¡tenemos muchas otras ideas increíbles para ti!
            </p>

            {{-- Botones de acción --}}
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('home') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-brand-purple to-brand-cyan hover:from-purple-500 hover:to-cyan-400 text-white font-bold py-3 px-8 rounded-xl transition-all duration-300 shadow-lg shadow-brand-cyan/20 transform hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Ir al Inicio
                </a>
                <a href="{{ route('catalogo') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-white/5 hover:bg-white/10 border border-white/10 text-white font-bold py-3 px-8 rounded-xl transition-all duration-300">
                    Ver Catálogo
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>