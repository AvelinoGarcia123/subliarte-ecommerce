<x-filament-panels::page>
    <!-- ✅ SWEETALERT2 LOCAL PARA ESTA PÁGINA -->
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
                customClass: {
                    popup: 'border border-gray-700 rounded-2xl shadow-2xl',
                    title: 'text-2xl font-bold',
                    confirmButton: 'px-8 py-3 rounded-xl font-bold'
                }
            });
         ">
    </div>

    <!-- FORMULARIO -->
    <x-filament-panels::form wire:submit="save">
        {{ $this->form }}

        <!-- BOTÓN CORREGIDO -->
        <div class="mt-8 flex justify-end">
            <x-filament::button type="submit" size="lg" class="px-10 py-3 text-base font-bold shadow-lg">
                Guardar Configuración
            </x-filament::button>
        </div>
    </x-filament-panels::form>
</x-filament-panels::page>