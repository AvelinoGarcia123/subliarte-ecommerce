<section class="space-y-6">
    <header>
        <h2 class="text-xl font-bold text-red-400 mb-1">Eliminar Cuenta</h2>
        <p class="text-sm text-gray-400 mb-6">Una vez que elimines tu cuenta, todos tus datos se borrarán permanentemente.</p>
    </header>

    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/30 font-bold py-2 px-6 rounded-xl transition">
        Eliminar mi cuenta
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-gray-900 text-white rounded-lg">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-white mb-2">¿Estás seguro de que quieres eliminar tu cuenta?</h2>
            <p class="text-sm text-gray-400 mb-6">Por favor, ingresa tu contraseña para confirmar que deseas eliminar tu cuenta permanentemente.</p>

            <div>
                <label for="password" class="sr-only">Contraseña</label>
                <input id="password" name="password" type="password" placeholder="Contraseña" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-3 text-white focus:border-red-500 focus:outline-none transition">
                @error('password', 'userDeletion') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="bg-white/5 hover:bg-white/10 text-white font-bold py-2 px-6 rounded-xl transition">
                    Cancelar
                </button>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-xl transition">
                    Eliminar Cuenta
                </button>
            </div>
        </form>
    </x-modal>
</section>