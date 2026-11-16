<section>
    <header>
        <h2 class="text-xl font-bold text-white mb-1">Información Personal</h2>
        <p class="text-sm text-gray-400 mb-6">Actualiza tu nombre y correo electrónico.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-sm font-medium text-gray-300 mb-1">Nombre Completo</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                class="w-full bg-brand-dark border rounded-xl px-4 py-3 text-white focus:outline-none transition
                @error('name') border-red-500 focus:border-red-500 @else border-white/10 focus:border-brand-cyan @enderror">
            @error('name') 
                <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> 
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Correo Electrónico</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                class="w-full bg-brand-dark border rounded-xl px-4 py-3 text-white focus:outline-none transition
                @error('email') border-red-500 focus:border-red-500 @else border-white/10 focus:border-brand-cyan @enderror">
            @error('email') 
                <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> 
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3">
                    <p class="text-sm text-gray-400">
                        Tu correo electrónico no está verificado.
                        <button form="send-verification" class="text-brand-cyan hover:text-white underline transition">
                            Haz clic aquí para reenviar el correo.
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-400">
                            Se ha enviado un nuevo enlace de verificación a tu correo.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="bg-gradient-to-r from-brand-purple to-brand-cyan hover:from-purple-500 hover:to-cyan-400 text-white font-bold py-2 px-6 rounded-xl transition shadow-lg shadow-brand-cyan/20">
                Guardar Cambios
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="text-sm text-green-400 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Guardado
                </p>
            @endif
        </div>
    </form>
</section>