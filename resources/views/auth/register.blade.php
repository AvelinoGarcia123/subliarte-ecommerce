<x-guest-layout>
    <!-- Título -->
    <div class="text-center mb-8">
        <h2 class="text-3xl font-extrabold text-white mb-2">Crea tu cuenta</h2>
        <p class="text-gray-400 text-sm">Únete a Subli-Arte y empieza a personalizar.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Nombre -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-300 mb-1">Nombre Completo</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-brand-purple focus:ring-1 focus:ring-brand-purple transition">
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400 text-sm" />
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Correo Electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-brand-purple focus:ring-1 focus:ring-brand-purple transition">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-sm" />
        </div>

        <!-- Contraseña -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-300 mb-1">Contraseña</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-brand-purple focus:ring-1 focus:ring-brand-purple transition">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-sm" />
        </div>

        <!-- Confirmar Contraseña -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-1">Confirmar Contraseña</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-brand-purple focus:ring-1 focus:ring-brand-purple transition">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400 text-sm" />
        </div>

        <!-- Botón -->
        <div>
            <button type="submit" class="w-full bg-gradient-to-r from-brand-purple to-brand-cyan hover:from-purple-500 hover:to-cyan-400 text-white font-bold py-3 px-4 rounded-xl transition duration-300 transform hover:scale-[1.02] shadow-lg shadow-brand-cyan/30">
                Registrarse
            </button>
        </div>

        <!-- Enlace a Login -->
        <div class="text-center mt-6">
            <p class="text-sm text-gray-400">¿Ya tienes una cuenta? 
                <a href="{{ route('login') }}" class="text-brand-cyan hover:text-white font-semibold transition">Inicia Sesión</a>
            </p>
        </div>
    </form>
</x-guest-layout>
