<div class="relative" wire:poll.10s="loadNotifications">
    <!-- Botón de la Campanita -->
    <button wire:click="toggle" class="relative p-2 text-gray-400 hover:text-white transition group">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
        
        @if($unreadCount > 0)
            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full group-hover:scale-110 transition">
                {{ $unreadCount }}
            </span>
        @endif
    </button>

    <!-- Menú Desplegable -->
    @if($isOpen)
        <div class="absolute right-0 mt-2 w-80 bg-gray-900 border border-white/10 rounded-xl shadow-2xl overflow-hidden z-50">
            <div class="flex justify-between items-center p-4 border-b border-white/10 bg-white/5">
                <h3 class="text-white font-bold">Notificaciones</h3>
                @if($unreadCount > 0)
                    <button wire:click="markAllAsRead" class="text-xs text-brand-cyan hover:text-white transition">Marcar leídas</button>
                @endif
            </div>

            <div class="max-h-96 overflow-y-auto">
                @forelse($notifications as $notif)
                    <div class="p-4 border-b border-white/5 hover:bg-white/5 transition {{ $notif->read_at ? 'opacity-60' : 'bg-brand-dark/50' }}">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-brand-cyan/20 flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-4 h-4 text-brand-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-white">{{ $notif->data['title'] }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $notif->data['body'] }}</p>
                                <p class="text-[10px] text-gray-500 mt-2">{{ $notif->created_at->diffForHumans() }}</p>
                            </div>
                            @if(!$notif->read_at)
                                <button wire:click="markAsRead('{{ $notif->id }}')" class="text-gray-500 hover:text-brand-cyan" title="Marcar como leída">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-500 text-sm">No tienes notificaciones nuevas.</div>
                @endforelse
            </div>
        </div>
    @endif
</div>