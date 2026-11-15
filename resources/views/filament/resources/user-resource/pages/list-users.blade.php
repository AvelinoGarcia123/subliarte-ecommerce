<x-filament-panels::page>
    @if(session()->has('swal_success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        <div x-data x-init="
            Swal.fire({
                title: @js(session('swal_success')['title']),
                text: @js(session('swal_success')['text']),
                icon: 'success',
                background: '#1f2937', 
                color: '#f3f4f6',      
                confirmButtonColor: '#8b5cf6', 
                confirmButtonText: 'Aceptar',
                backdrop: 'rgba(0, 0, 0, 0.8)', 
                allowOutsideClick: false,
                allowEscapeKey: false,
                customClass: {
                    popup: 'border border-gray-700 rounded-2xl shadow-2xl',
                    title: 'text-2xl font-bold',
                    confirmButton: 'px-8 py-3 rounded-xl font-bold'
                }
            });
        "></div>
    @endif

    {{ $this->table }}
</x-filament-panels::page>