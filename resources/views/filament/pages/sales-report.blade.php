<x-filament-panels::page>
    <!-- Formulario de filtros -->
    <x-filament-panels::form>
        {{ $this->form }}
    </x-filament-panels::form>

    <!-- Tabla de resultados -->
    <div class="mt-6">
        {{ $this->table }}
    </div>
</x-filament-panels::page>