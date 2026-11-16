<x-layouts.app>
    <div class="max-w-4xl mx-auto px-4 py-16 min-h-screen">
        
        <div class="mb-10 border-b border-white/10 pb-4 flex justify-between items-end">
            <div>
                <h1 class="text-4xl font-extrabold text-white mb-2">Mi Perfil</h1>
                <p class="text-gray-400">Administra tu información personal y seguridad.</p>
            </div>
            <a href="{{ route('home') }}" class="text-sm text-brand-cyan hover:text-white transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Volver a la tienda
            </a>
        </div>

        <div class="space-y-6">
            <div class="bg-white/5 border border-white/10 rounded-2xl p-8 backdrop-blur-md">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="bg-white/5 border border-white/10 rounded-2xl p-8 backdrop-blur-md">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="bg-red-500/5 border border-red-500/20 rounded-2xl p-8 backdrop-blur-md">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
