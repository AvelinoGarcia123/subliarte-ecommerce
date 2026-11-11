<x-filament-panels::page>
    <x-filament-panels::form wire:submit="save">
        {{ $this->form }}

        <div class="mt-8 flex justify-end">
            <x-filament::button type="submit" size="lg" class="px-10 py-3 text-base font-bold shadow-lg">
                Guardar Cambios
            </x-filament::button>
        </div>
    </x-filament-panels::form>
</x-filament-panels::page>