<x-filament-panels::page>
    <!-- ✅ Script de SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <div x-data 
         @swal:success.window="
            Swal.fire({
                title: $event.detail[0].title,
                text: $event.detail[0].text,
                icon: 'success',
                background: '#1f2937', 
                color: '#f3f4f6',      
                confirmButtonColor: '#8b5cf6', 
                confirmButtonText: 'Aceptar',
                backdrop: 'rgba(0, 0, 0, 0.8)', 
                allowOutsideClick: false, /* ✅ BLOQUEA CLIC FUERA */
                allowEscapeKey: false, 
                customClass: {
                    popup: 'border border-gray-700 rounded-2xl shadow-2xl',
                    title: 'text-2xl font-bold',
                    confirmButton: 'px-8 py-3 rounded-xl font-bold'
                }
            });
         ">
    </div>

    <!-- La tabla de Filament -->
    {{ $this->table }}
</x-filament-panels::page>