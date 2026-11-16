<section>
    <header>
        <h2 class="text-xl font-bold text-white mb-1">Seguridad</h2>
        <p class="text-sm text-gray-400 mb-6">Asegúrate de usar una contraseña larga y segura.</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <!-- Contraseña Actual -->
        <div>
            <label for="current_password" class="block text-sm font-medium text-gray-300 mb-1">Contraseña Actual</label>
            <input id="current_password" name="current_password" type="password" autocomplete="current-password"
                class="w-full bg-brand-dark border rounded-xl px-4 py-3 text-white focus:outline-none transition
                @error('current_password', 'updatePassword') border-red-500 focus:border-red-500 @else border-white/10 focus:border-brand-cyan @enderror">
            @error('current_password', 'updatePassword') 
                <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> 
            @enderror
        </div>

        <!-- Nueva Contraseña -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-300 mb-1">Nueva Contraseña</label>
            <input id="password" name="password" type="password" autocomplete="new-password"
                class="w-full bg-brand-dark border rounded-xl px-4 py-3 text-white focus:outline-none transition
                @error('password', 'updatePassword') border-red-500 focus:border-red-500 @else border-white/10 focus:border-brand-cyan @enderror">
            @error('password', 'updatePassword') 
                <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> 
            @enderror
        </div>

        <!-- Confirmar Contraseña -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-1">Confirmar Nueva Contraseña</label>
            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                class="w-full bg-brand-dark border rounded-xl px-4 py-3 text-white focus:outline-none transition
                @error('password_confirmation', 'updatePassword') border-red-500 focus:border-red-500 @else border-white/10 focus:border-brand-cyan @enderror">
            @error('password_confirmation', 'updatePassword') 
                <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> 
            @enderror
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="bg-gradient-to-r from-brand-purple to-brand-cyan hover:from-purple-500 hover:to-cyan-400 text-white font-bold py-2 px-6 rounded-xl transition shadow-lg shadow-brand-cyan/20">
                Actualizar Contraseña
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="text-sm text-green-400 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    ¡Contraseña actualizada!
                </p>
            @endif
        </div>
    </form>
</section>