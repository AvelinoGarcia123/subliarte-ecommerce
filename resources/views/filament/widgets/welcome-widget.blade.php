<div 
    id="welcome-banner"
    class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-brand-purple to-brand-cyan p-6 sm:p-8 shadow-lg transition-all duration-500"
>
    <!-- Botón para cerrar manualmente -->
    <button onclick="document.getElementById('welcome-banner').style.display='none'" class="absolute top-4 right-4 text-white/50 hover:text-white transition z-20 bg-black/20 rounded-full p-1">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>

    <div class="absolute inset-0 bg-grid-pattern opacity-20"></div>
    
    <div class="relative z-10 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-white mb-2">¡Hola, {{ auth()->user()->name }}! 👋</h2>
            <p class="text-white/80 max-w-xl">
                Bienvenido al panel de control de <strong>Subli-Arte F.P.</strong> Aquí puedes gestionar tus productos, pedidos y clientes. ¡Que tengas un excelente día de ventas!
            </p>
        </div>
        <div class="hidden md:block">
            <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-md border border-white/30 shadow-inner">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            var banner = document.getElementById('welcome-banner');
            if (banner) {
                banner.style.opacity = '0';
                banner.style.maxHeight = '0';
                banner.style.paddingTop = '0';
                banner.style.paddingBottom = '0';
                banner.style.marginBottom = '0';
                banner.style.overflow = 'hidden';
            }
        }, 5000); // ✅ 5000 = 5 segundos (para probar). Cambia a 60000 para 60 segundos.
    });
</script>