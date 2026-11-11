<x-guest-layout>
    <!-- Título -->
    <div class="text-center mb-8">
        <h2 class="text-3xl font-extrabold text-white mb-2">Bienvenido de nuevo</h2>
        <p class="text-gray-400 text-sm">Ingresa a tu cuenta para gestionar tus pedidos.</p>
    </div>

    <!-- Mensaje de Sesión -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Correo Electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-brand-cyan focus:ring-1 focus:ring-brand-cyan transition">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-sm" />
        </div>

        <!-- Contraseña -->
        <div>
            <div class="flex justify-between items-center mb-1">
                <label for="password" class="block text-sm font-medium text-gray-300">Contraseña</label>
                @if (Route::has('password.request'))
                    <a class="text-xs text-brand-cyan hover:text-white transition" href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-brand-cyan focus:ring-1 focus:ring-brand-cyan transition">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-sm" />
        </div>

        <!-- Recordarme -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember" class="rounded bg-white/5 border-white/10 text-brand-cyan focus:ring-brand-cyan focus:ring-offset-brand-darker">
            <label for="remember_me" class="ml-2 text-sm text-gray-400">Recordarme</label>
        </div>

        <!-- Botón -->
        <div>
            <button type="submit" class="w-full bg-gradient-to-r from-brand-purple to-brand-cyan hover:from-purple-500 hover:to-cyan-400 text-white font-bold py-3 px-4 rounded-xl transition duration-300 transform hover:scale-[1.02] shadow-lg shadow-brand-purple/30">
                Iniciar Sesión
            </button>
        </div>

        <!-- Enlace a Registro -->
        <div class="text-center mt-6">
            <p class="text-sm text-gray-400">¿No tienes una cuenta? 
                <a href="{{ route('register') }}" class="text-brand-cyan hover:text-white font-semibold transition">Regístrate aquí</a>
            </p>
        </div>
    </form>
</x-guest-layout>